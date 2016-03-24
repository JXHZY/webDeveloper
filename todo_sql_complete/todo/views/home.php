<?php
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../controller/ensure_session.php");

$navMarkup = "";
$navMarkup = $navMarkup . "<li><a href=\"" . APPLICATION_ROOT . "/views/home.php\">Tasks</a></li>";
$navMarkup = $navMarkup . "<li><a href=\"" . APPLICATION_ROOT . "/controller/auth.php\">Logout</a></li>";
require_once(__DIR__ . "/../service/data_service.php");
$tasks = array();
if(isset($_SESSION[CURRENT_USER])){
    $userId = $_SESSION[CURRENT_USER];
    $tasks = get_todos($userId);
}
require_once("header.php");
?>

        <div class="container">
            <form action="<?php echo CONTROLLER ?>/todo.php" method="POST">
                <div class="row" style="margin-top:20px">
                    <div class="col-xs-12">
                        <h4>New Task</h4>
                    </div>                
                </div>
                <div class="clearfix" ></div>
                <?php
                if(isset($_SESSION["errors"])){
                ?>
                <!-- ERRORS -->
                <div class="row" style="margin-top:20px">
                    <div class="col-xs-12 alert alert-block bg-danger">                    
                    <?php 
                    $errors =  $_SESSION["errors"];       
                    $noErrors = count($errors);
                    for($errIndex=0; $errIndex<$noErrors; $errIndex++){
                        echo "<div>" . $errors[$errIndex] . "</div>";
                    }

                    unset($_SESSION["errors"]); 
                    ?>
                    </div>                    
                </div>
                <div class="clearfix" ></div>
                <?php
                }

                if(isset($_SESSION["success"])){
                ?>
                <!-- SUCCESSES -->
                <div class="row" style="margin-top:20px">
                    <div class="col-xs-12 alert alert-block bg-success">
                        <?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?>
                    </div>
                </div>
                <div class="clearfix" ></div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="col-xs-2">
                        <label>Description</label>
                    </div>
                    <div class="col-xs-10">
                        <input type="text" name="description" size="100" />
                    </div>
                </div>
                <div class="clearfix" ></div>
                <div class="row" style="margin-top: 5px">
                    <div class="col-xs-2">
                        <label>Scheduled Date</label>
                    </div>
                    <div class="col-xs-10"><?php $maxDate = strtotime("+7 day");?>
                        <input type="date" name="scheduledDate" min="<?php echo date('Y-m-d'); ?>" 
                            max="<?php echo date('Y-m-d',$maxDate); ?>" value="<?php echo date('Y-m-d'); ?>" />
                        <input type="submit" name="action" value="Add" />
                    </div>
                </div>
                <div class="clearfix" ></div>
                <div class="row">&nbsp;</div>
                <div class="clearfix" ></div>                
                <div class="row" style="margin-top:20px">
                    <div class="col-xs-12">
                        <h4>Todos</h4>
                    </div>
                </div>
                <div class="clearfix" ></div>
                <div class="row" style="margin-top:5px">
                    <div class="col-xs-12">
                        <table>
                            <thead>
                                <?php
                                if (count($tasks) > 0) {
                                ?>
                                    <tr>
                                        <th colspan="4">
                                            <input type="submit" name="action" value="Edit" />
                                            <input type="submit" name="action" value="Delete" id="deleteBtn" />
                                        </th>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <th>Select</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Scheduled Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($tasks) == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="4">
                                            No tasks found. Enjoy your day. :)
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    for ($index = 0; $index < count($tasks); $index++) {
                                        $task = $tasks[$index];
                                        ?>
                                        <tr>
                                            <td class="select">
                                                <input type="radio" name="todoId" value="<?php echo $task[todo_ID] ?>" />
                                            </td>
                                            <td class="description"><?php echo $task[todo_DESCRIPTION] ?></td>
                                            <td class="status"><?php echo $task[todo_STATUS] ?></td>
                                            <td class="date"><?php echo $task[todo_DATE] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </form>
        </div><!-- /.container -->
<?php
require_once("footer.php");
?>