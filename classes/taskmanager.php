<?php
class TaskManager {
  private $db;

  public function __construct(PDO $db){
    $this->db = $db;
  }

  // Saves the title and description of a task to the database.
  public function save(Task $task){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into Task (title, body)
        values (:title, :body)
    ");
    $worked = $r->execute(
      ['title' => $task->getTitle(),
       'body' => $task->getDescription()]);
    if (!$worked) {
      return false;
    }
    $task->setId($this->db->lastInsertId());
    $this->db->commit();
    return $task;
  }

  // Association of a task is made to a user on another table. Many users to many tasks can be associated.
  public function associateTaskToUser($taskId, $userId) {
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into User_Task (userId, taskId, progress, lastChanged)
        values (:userId, :taskId, :progress, now())
    ");
    $worked = $r->execute(
      ['userId' => $userId,
       'taskId' => $taskId,
       'progress' => "Not Started"]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  // Task is found by its id
  public function byId($id){
    $s = $this->db->prepare("
      select
          Task.id, Task.title, Task.body, User_Task.progress , User_Task.lastChanged
      from Task
      inner join User_Task
      on Task.id = User_Task.taskId
      where Task.id = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $task = new Task($this->db);
    $task->fromArray($row);
    return $task;
  }

  // Returns all of the tasks that are not completed.
  public function allPending($option){
    $tasks = [];
    if ($option == "In Progress") {
      // Only returns tasks in progress. This is ordered by the last updated task.
      $s = $this->db->prepare("
        select
            user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
        from Task
        inner join user_task
        on task.id = user_task.taskId
        inner join user
        on user.id = user_task.userId
        where user_task.progress = :completed
        order by user_task.lastChanged desc
      ");
      $s->execute(['completed' => "In Progress"]);
    } elseif ($option == "Not Started") {
      // Only returns tasks that have not been started. This is ordered by the last updated task.
      $s = $this->db->prepare("
        select
           user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
        from Task
        inner join user_task
        on task.id = user_task.taskId
        inner join user
        on user.id = user_task.userId
        where user_task.progress = :completed
        order by user_task.lastChanged desc
      ");
     $s->execute(['completed' => "Not Started"]);
   } elseif ($option == "Time") {
     // This returns the tasks in order of the most recently updated task.
      $s = $this->db->prepare("
        select
            user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
        from Task
        inner join user_task
        on task.id = user_task.taskId
        inner join user
        on user.id = user_task.userId
        where not user_task.progress = :completed
        order by user_task.lastChanged desc, user_task.progress asc, user.surname asc
      ");
      $s->execute(['completed' => "Completed"]);
    } elseif ($option == "All") {
      // Returns all of the tasks not yet completed, split by progression in order of most recently updated.
      $s = $this->db->prepare("
        select
            user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
        from Task
        inner join user_task
        on task.id = user_task.taskId
        inner join user
        on user.id = user_task.userId
        where not user_task.progress = :completed
        order by user_task.progress asc, user_task.lastChanged desc, user.surname asc
      ");
      $s->execute(['completed' => "Completed"]);
    }else {
      // Default return.
      $s = $this->db->prepare("
        select
            user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
        from Task
        inner join user_task
        on task.id = user_task.taskId
        inner join user
        on user.id = user_task.userId
        where not user_task.progress = :completed
        order by user_task.lastChanged desc, user.surname asc
      ");
      $s->execute(['completed' => "Completed"]);
    }
    foreach ($s as $row) {
      array_push($tasks, ['userId' => $row['userId'],
                          'taskId' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['body'],
                          'progress' => $row['progress'],
                          'firstname' => $row['firstname'],
                          'surname' => $row['surname'],
                          'email' => $row['email']]);
    }
    return $tasks;
  }

  // Returns a list of all of the completed tasks.
  public function allCompleted(){
    $tasks = [];
    $s = $this->db->prepare("
    select
        user.id as userId, task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email, user_task.lastChanged
    from Task
    inner join user_task
    on task.id = user_task.taskId
    inner join user
    on user.id = user_task.userId
    where user_task.progress = :completed
    order by user_task.lastChanged desc
    ");
    $s->execute(['completed' => "Completed"]);
    foreach ($s as $row) {
      array_push($tasks, ['userId' => $row['userId'],
                          'taskId' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['body'],
                          'progress' => $row['progress'],
                          'firstname' => $row['firstname'],
                          'surname' => $row['surname'],
                          'email' => $row['email']]);
    }
    return $tasks;
  }

  // Returns the tasks that are associated to a userId.
  public function byUserId($id, $completed=false){
    $tasks = [];
    if ($completed) {
      $s = $this->db->prepare("
        select task.id, task.title, task.body, user_task.progress, user_task.lastChanged
        from Task
        inner join User_Task
        on task.id = user_task.taskId
        where (user_task.userId = :id and user_task.progress = :completed)
        order by user_task.lastChanged desc
      ");
    } else {
      $s = $this->db->prepare("
        select task.id, task.title, task.body, user_task.progress, user_task.lastChanged
        from Task
        inner join User_Task
        on task.id = user_task.taskId
        where (user_task.userId = :id and not user_task.progress = :completed)
        order by user_task.progress asc, user_task.lastChanged desc
      ");
    }
    $s->execute(['id' => $id,
                 'completed' => "Completed"]);
    foreach ($s as $row) {
      array_push($tasks, ['taskId' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['body'],
                          'progress' => $row['progress'],
                          'lastChanged' => $row['lastChanged']]);
    }
    return $tasks;
  }

  // Updating the progress of a task for a given user.
  public function updateProgress($userId, $taskId, $progress){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update User_Task
        set progress = :progress, lastChanged = now()
        where (userId = :userId and taskId = :taskId)
    ");
    $worked = $r->execute(
      ['userId' => $userId,
       'taskId' => $taskId,
       'progress' => $progress]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  // Updates the content of an already existing task.
  public function updateContent(Task $task){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update Task
        set title = :title, body = :body
        where id = :taskId
    ");
    $worked = $r->execute(
      ['taskId' => $task->getId(),
       'title' => $task->getTitle(),
       'body' => $task->getDescription()]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The task has been updated.";
    return true;
  }

  // The time will be updated with each transaction with the task id.
  public function updateTime($taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update User_Task
        set lastChanged = now()
        where taskId = :taskId
    ");
    $worked = $r->execute(
      ['taskId' => $taskId]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  // Task Deletion.
  public function deleteTask($taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        delete from Task
        where id = :id
    ");
    $worked = $r->execute(['id' => $taskId]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  // remove associoation of task and user.
  public function deleteUserTask($taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        delete from User_Task
        where taskId = :taskId
    ");
    $worked = $r->execute(['taskId' => $taskId]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The task has been deleted.";
    return true;
  }

  // Remove a single user from a task.
  public function removeUserFromTask($userId, $taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        delete from User_Task
        where (userID = :userId and taskId = :taskId)
    ");
    $worked = $r->execute(['userId' => $userId,
                           'taskId' => $taskId]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The task has been deleted.";
    return true;
  }

  // Returns how many users are assigned to complete a task.
  public function howManyAssigned($id){
    $s = $this->db->prepare("
      select
          count(userId)
      from User_Task
      where taskId = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    return $row['count(userId)'];
  }
}
?>
