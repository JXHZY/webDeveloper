<?php
$navMarkup = "&nbsp;";
require_once("header.php");
if(session_id() == '' || !isset($_SESSION)) {
     // session isn't started
    session_start();
}
?>

		<div class="container">            
            <div class="row" style="margin-top:20px">
                <div class="col-xs-12">
                    <h4>Error occured</h4>
                </div>
            </div>
            <div class="row" style="margin-top:20px">
                <div class="col-xs-12">
                    <?php
                    $error = array (
						"code"=>"Unknown",
						"desc"=>"Unknown",
						"file"=>"Unknown",
						"line"=>"Unknown",
						"context"=>"Unknown"
					);

                    if(isset($_SESSION["ERROR_INFO"])){
                    	$error = $_SESSION["ERROR_INFO"];
                    }                    
                    ?>
                    Code: <?php echo $error["code"]; ?><br/>
                    Description: <?php echo $error["desc"]; ?><br/>
                    File: <?php echo $error["file"]; ?><br/>
                    Line: <?php echo $error["line"]; ?><br/>
                    
                </div>
            </div>
        </div>

<?php
session_unset();
session_destroy();
require_once("footer.php");
?>