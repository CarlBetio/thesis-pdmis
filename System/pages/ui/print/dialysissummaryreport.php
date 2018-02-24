<?php require '../session.php'; ?>
<html>
    
    <head>
    
   
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

        <!-- Bootstrap Select Css -->
        <link href="../../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
        <!-- Bootstrap Core Css -->
        <link href="../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="../../../plugins/node-waves/waves.css" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="../../../plugins/animate-css/animate.css" rel="stylesheet" />

        <!-- JQuery DataTable Css -->
        <link href="../../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

        
        <!-- mytable Css -->
        <link href="../../../css/table.css" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="../../../css/themes/theme-indigo.css" rel="stylesheet" />
    </head>
    <body>
            <?php 
                date_default_timezone_set('Asia/Manila');
                $pname = '';
                $from = '';
                $from = $_POST['reportdate1']; //required
                $to = empty($_POST['reportdate2']) ? date('Y-m-d') : $_POST['reportdate2'];
                $pname = $_POST['patientid']; 
            ?>
        
            <?php 
            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
             $queryp = $conn->query("SELECT `Hospital_Id`,`P_Date`,`P_Diagnosis`,`nephrologistid`, `P_Lname`, `P_Fname`, `P_Mname`, `Hospital_Id` FROM `patientprofile` WHERE `Hospital_Id` = '$pname'") or die(mysqli_error());
            $fetchp = $queryp ->fetch_array();
            $nid = $fetchp['nephrologistid'];
            $hid = $fetchp['Hospital_Id'];
        
            $queryn = $conn->query("SELECT `n_lname`,`n_mname`,`n_fname` FROM `nephrologist` WHERE `nephrologistid` = '$nid'") or die(mysqli_error());
            $fetchn = $queryn ->fetch_array();
        
             $querys = $conn->query("SELECT `treatment_day`,`treatment_time` FROM `patientschedule` WHERE `Hospital_Id` = '$hid'") or die(mysqli_error());
            $fetchs = $querys ->fetch_array();
            ?>
                
             <?php if(isset($_POST['dialysisdetail1'])){ ?>
                    
                  <?php if(empty($_POST['patientid'])){ ?>
            
                  <div id="printableArea">
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT CONFINEMENT RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                        
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>
                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>Treatment Start</th>
                                                                    <th>Treatment End</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `treatment`.`treatment_start`, `treatment`.`treatment_end`, `patientprofile`.`Hospital_Id`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`initialtestresult`.`initialtest_time`,`treatment`.`treatment_date` FROM `patientprofile` INNER JOIN `initialtestresult` ON `patientprofile`.`Hospital_Id` = `initialtestresult`.`Hospital_Id` INNER JOIN `treatment` ON `patientprofile`.`Hospital_Id` = `treatment`.`Hospital_Id`  WHERE `treatment`.`treatment_date` BETWEEN '$from' AND '$to' GROUP BY `treatment`.`treatment_date`") or die(mysqli_error());
                                                          // $id = $fetch['Hospital_Id'];
                                                            
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                    <tr>

                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                      <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                         <td>
                                                                            <?php echo $fetch['treatment_start']?>
                                                                        </td>

                                                                         <td>
                                                                            <?php echo $fetch['treatment_end']?>
                                                                        </td>

                                                                        <td>
                                                                            <?php echo $fetch['treatment_date']?>
                                                                        </td>


                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
                  <?php }else{ ?>
                    
                    <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT CONFINEMENT RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                        
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Treatment Start</th>
                                                                    <th>Treatment End</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        <?php
                                                            $total = 0;
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `treatment_date`, `treatment_start`, `treatment_end` FROM `treatment` WHERE `treatment`.`treatment_date` BETWEEN '$from' AND '$to' AND `treatment`.`Hospital_Id` = '$pname' GROUP BY `treatment`.`treatment_date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                               $total = $total + 1;
                                                        ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $fetch['treatment_start']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $fetch['treatment_end']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $fetch['treatment_date']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Total Number of Treatments: <u><?php echo $total?></u></b><br>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
                <?php } ?>
                <?php } ?>
        
        
        
        
        <?php if(isset($_POST['dialysisdetail2'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                        
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>

                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>PreWeight</th>
                                                                    <th>PostWeight</th>
                                                                     <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`treatment`.`Hospital_Id`,`treatment`.`treatment_date`,`treatment`.`preweight`,`treatment`.`postweight` FROM `treatment` INNER JOIN `patientprofile` ON `treatment`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `treatment`.`treatment_date` BETWEEN '$from' AND '$to' GROUP BY `treatment`.`treatment_date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>

                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                      <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                         <td>
                                                                            <?php echo $fetch['preweight']?>
                                                                        </td>
                                                                         <td>
                                                                            <?php echo $fetch['postweight']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $fetch['treatment_date']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                        <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>PreWeight</th>
                                                                    <th>PostWeight</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`treatment`.`Hospital_Id`,`treatment`.`treatment_date`,`treatment`.`preweight`,`treatment`.`postweight` FROM `treatment` INNER JOIN `patientprofile` ON `treatment`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `treatment`.`treatment_date` BETWEEN '$from' AND '$to'
                                                            AND `treatment`.`Hospital_Id` = '$pname' 
                                                            GROUP BY `treatment`.`treatment_date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                         <td>
                                                                            <?php echo $fetch['preweight']." KG"?>
                                                                         </td>
                                                                         <td>
                                                                            <?php echo $fetch['postweight']." KG"?>
                                                                         </td>
                                                                         <td>
                                                                            <?php echo $fetch['treatment_date']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>       
        <?php } ?>
        
        
        <?php if(isset($_POST['dialysisdetail3'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                        
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>

                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>Illness And Operation</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `patientprofile`.`Hospital_Id`,`diagnostic/examination`.`DM`, `diagnostic/examination`.`HPN`,`diagnostic/examination`.`PTB`,`diagnostic/examination`.`Cancer`,`diagnostic/examination`.`Asthma`,`diagnostic/examination`.`PIO_others`,`patientprofile`.`P_Lname`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname` FROM `patientprofile` INNER JOIN `diagnostic/examination` ON `diagnostic/examination`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `diagnostic/examination`.`date` BETWEEN '$from' AND '$to' GROUP BY `diagnostic/examination`.`date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                      <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                         <td>
                                                                              <?php if($fetch['DM']=='1') echo "DM";?>
                                                                              <?php if($fetch['HPN']=='1') echo "HPN";?>
                                                                              <?php if($fetch['PTB']=='1') echo "PTB";?>
                                                                              <?php if($fetch['Cancer']=='1') echo "Cancer";?>
                                                                              <?php if($fetch['Asthma']=='1') echo "Asthma";?>
                                                                              <?php if($fetch['PIO_others']!='') echo $fetch['PIO_others']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                        <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                
                                                <div class="body">
                                                    <div class="table-responsive">
                                                          <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Doneon</th>
                                                                    <th>Illness And Operation</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `diagnostic/examination`.`Doneon`, `patientprofile`.`Hospital_Id`,`diagnostic/examination`.`DM`, `diagnostic/examination`.`HPN`,`diagnostic/examination`.`PTB`,`diagnostic/examination`.`Cancer`,`diagnostic/examination`.`Asthma`,`diagnostic/examination`.`PIO_others`,`patientprofile`.`P_Lname`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname` FROM `patientprofile` INNER JOIN `diagnostic/examination` ON `diagnostic/examination`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `diagnostic/examination`.`date` BETWEEN '$from' AND '$to' GROUP BY `diagnostic/examination`.`date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Doneon']?>
                                                                        </td>
                                                                         <td>
                                                                              <?php if($fetch['DM']=='1') echo "DM";?>
                                                                              <?php if($fetch['HPN']=='1') echo "HPN";?>
                                                                              <?php if($fetch['PTB']=='1') echo "PTB";?>
                                                                              <?php if($fetch['Cancer']=='1') echo "Cancer";?>
                                                                              <?php if($fetch['Asthma']=='1') echo "Asthma";?>
                                                                              <?php if($fetch['PIO_others']!='') echo $fetch['PIO_others']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>
        <?php }?>
        
        <?php if(isset($_POST['dialysisdetail4'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                        
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>

                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>Personal/Social History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `patientprofile`.`Hospital_Id`,`diagnostic/examination`.`Alcoholintake`, `diagnostic/examination`.`SmokingHistory`,`diagnostic/examination`.`DrugAllergy`,`diagnostic/examination`.`FoodAllergy`,`diagnostic/examination`.`PSH_others`,`patientprofile`.`P_Lname`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname` FROM `patientprofile` INNER JOIN `diagnostic/examination` ON `diagnostic/examination`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `diagnostic/examination`.`date` BETWEEN '$from' AND '$to' GROUP BY `diagnostic/examination`.`date`") or die(mysqli_error());
                                                        
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                      <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                         <td>
                                                                              <?php if($fetch['Alcoholintake']=='1') echo "Alcohol intake";?>
                                                                              <?php if($fetch['SmokingHistory']=='1') echo "Smoking History";?>
                                                                              <?php if($fetch['DrugAllergy']=='1') echo "Drug Allergy";?>
                                                                              <?php if($fetch['FoodAllergy']=='1') echo "Food Allergy";?>
                                                                      
                                                                              <?php if($fetch['PSH_others']!='') echo $fetch['PSH_others']?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                
                                        <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                
                                                <div class="body">
                                                   <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Done On</th>
                                                                    <th>Personal/Social History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php   
                                                            
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("Select `patientprofile`.`Hospital_Id`,`diagnostic/examination`.`Alcoholintake`, `diagnostic/examination`.`SmokingHistory`,`diagnostic/examination`.`DrugAllergy`,`diagnostic/examination`.`FoodAllergy`,`diagnostic/examination`.`PSH_others`,`patientprofile`.`P_Lname`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname` FROM `patientprofile` INNER JOIN `diagnostic/examination` ON `diagnostic/examination`.`Hospital_Id` = `patientprofile`.`Hospital_Id` WHERE `diagnostic/examination`.`date` BETWEEN '$from' AND '$to' AND `diagnostic/examination`.`Hospital_Id` = '$pname' GROUP BY `diagnostic/examination`.`date`") or die(mysqli_error());
                                                               
                                                           while($fetch = $query -> fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                         <td>
                                                                              <?php if($fetch['Alcoholintake']=='1') echo "Alcohol intake";?>
                                                                              <?php if($fetch['SmokingHistory']=='1') echo "Smoking History";?>
                                                                              <?php if($fetch['DrugAllergy']=='1') echo "Drug Allergy";?>
                                                                              <?php if($fetch['FoodAllergy']=='1') echo "Food Allergy";?> 
                                                                              <?php if($fetch['PSH_others']!='') echo $fetch['PSH_others'];?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }
                                                        ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>
        <?php }?>
        
         <?php if(isset($_POST['dialysisdetail5'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT ESRD HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>
                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>ESRD History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `hemo_order`.`esrd_diabetic`, `hemo_order`.`esrd_chronic`, `hemo_order`.`esrd_hypertensive`, `hemo_order`.`esrd_others`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`patientprofile`.`Hospital_Id` FROM `hemo_order` INNER JOIN `patientprofile` ON `patientprofile`.`Hospital_Id` = `hemo_order`.`Hospital_id`  WHERE `hemo_order`.`order_date` BETWEEN '$from' AND '$to' GROUP BY `hemo_order`.`order_date`") or die(mysqli_error());
                                                                            
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                        <td>
                                                                              <?php if($fetch['esrd_diabetic']=='1') echo "Diabetic Nephropathy";?>
                                                                              <?php if($fetch['esrd_chronic']=='1') echo "Chronic Gromerulonephritis";?>
                                                                              <?php if($fetch['esrd_hypertensive']=='1') echo "Hypertensive Nephrosclerosis";?>
                                                                              <?php if($fetch['esrd_others']=='1') echo $fetch['esrd_others'];?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT HISTORY RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                
                                        <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                
                                                <div class="body">
                                                   <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>ESRD History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php   
                                                            
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `hemo_order`.`esrd_diabetic`, `hemo_order`.`order_date`, `hemo_order`.`esrd_chronic`, `hemo_order`.`esrd_hypertensive`, `hemo_order`.`esrd_others`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`patientprofile`.`Hospital_Id` FROM `hemo_order` INNER JOIN `patientprofile` ON `patientprofile`.`Hospital_Id` = `hemo_order`.`Hospital_id`  WHERE `hemo_order`.`order_date` BETWEEN '$from' AND '$to' AND `hemo_order`.`Hospital_id` = '$pname' GROUP BY `hemo_order`.`order_date`") or die(mysqli_error());
                                                               
                                                           while($fetch = $query -> fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['order_date']?>
                                                                        </td>
                                                                          <td>
                                                                              <?php if($fetch['esrd_diabetic']=='1') echo "Diabetic Nephropathy";?>
                                                                              <?php if($fetch['esrd_chronic']=='1') echo "Chronic Gromerulonephritis";?>
                                                                              <?php if($fetch['esrd_hypertensive']=='1') echo "Hypertensive Nephrosclerosis";?>
                                                                              <?php if($fetch['esrd_others']=='1') echo $fetch['esrd_others'];?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }
                                                        ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>
        <?php }?>
           <?php if(isset($_POST['dialysisdetail6'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT ACCESS RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>
                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Hospital ID</th>
                                                                    <th>Name</th>
                                                                    <th>Access History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `hemo_order`.`access`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`patientprofile`.`Hospital_Id` FROM `hemo_order` INNER JOIN `patientprofile` ON `patientprofile`.`Hospital_Id` = `hemo_order`.`Hospital_id`  WHERE `hemo_order`.`order_date` BETWEEN '$from' AND '$to' GROUP BY `hemo_order`.`order_date`") or die(mysqli_error());
                                                                            
                                                           while($fetch = $query ->fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['Hospital_Id']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                        <td>
                                                                        <?php if($fetch['access']=='0') echo "Dialysis Catheter";?>
                                                                        <?php if($fetch['access']=='1') echo "Subclavian";?>
                                                                        <?php if($fetch['access']=='2') echo "Internal Jugular";?>
                                                                        <?php if($fetch['access']=='3') echo "Femoral";?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT ACCESS RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                
                                        <div class="header bg-indigo">
                                                    <h4><br><br>
                                                        <p>Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?></p>
                                                    </h4>
                                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                
                                                <div class="body">
                                                   <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Access History</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php   
                                                            
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `hemo_order`.`order_date`,`hemo_order`.`access`,`patientprofile`.`P_Fname`,`patientprofile`.`P_Mname`,`patientprofile`.`P_Lname`,`patientprofile`.`Hospital_Id` FROM `hemo_order` INNER JOIN `patientprofile` ON `patientprofile`.`Hospital_Id` = `hemo_order`.`Hospital_id` WHERE `hemo_order`.`order_date` BETWEEN '$from' AND '$to' AND `hemo_order`.`Hospital_id` = '$pname' GROUP BY `hemo_order`.`order_date`") or die(mysqli_error());
                                                               
                                                           while($fetch = $query -> fetch_array()){
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                            <?php echo $fetch['order_date']?>
                                                                        </td>
                                                                         <td>
                                                                        <?php if($fetch['access']=='0') echo "Dialysis Catheter";?>
                                                                        <?php if($fetch['access']=='1') echo "Subclavian";?>
                                                                        <?php if($fetch['access']=='2') echo "Internal Jugular";?>
                                                                        <?php if($fetch['access']=='3') echo "Femoral";?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                           }
                                                        ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>
        <?php }?>
            <?php if(isset($_POST['dialysisdetail7'])){ ?>
         <?php if(empty($_POST['patientid'])){ ?>
             <div id="printableArea">
                        
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT POPULATION RECORD</h4>
                                        </center>
                                        </div>
                                </div>
                                           <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header bg-indigo">
                                                    <h4>
                                                        <b>List of Patients</b>
                                                    </h4>
                                                </div>
                                                <div class="body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover js-basic-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Year</th>
                                                                    <th>Month</th>
                                                                    <th>Patient Name</th>
                                                                </tr>
                                                            </thead>    
                                                            <tbody>
                                                        <?php
                                                        
                                                            $conn = new mysqli("localhost", "root", "", "PDMIS") or die(mysqli_error());
                                                           $query = $conn->query("SELECT `P_Lname`,`P_Mname`,`P_Fname`,`P_Date` FROM `patientprofile` WHERE `P_Date` BETWEEN '$from' AND '$to'") or die(mysqli_error());
                                                                            
                                                           while($fetch = $query ->fetch_array()){
                                                              
                                                        ?>
                                                                   <tr>
                                                                        <td>
                                                                        <?php echo date("Y", strtotime($fetch['P_Date'])) ?>
                                                                        </td>
                                                                        <td>
                                                                      <?php echo date("M", strtotime($fetch['P_Date'])) ?>
                                                                        </td>
                                                                        <td>
                                                                        <?php echo $fetch['P_Fname']. " " .$fetch['P_Mname']. " " .$fetch['P_Lname']?>
                                                                        </td>
                                                                  </tr>
                                                            
                                                                        
                                                                    <?php
                                                           }

                                                        ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
            <?php }else{ ?>
            <div id="printableArea">
                            <div class="body">
                            
                                    <div class="row clearfix">
                                         <div class="col-lg-12 col-md-12 center">
                                        <center>
                                        <h4>TERESITA L. JALANDONI PROVINCIAL HOSPITAL</h4>
                                        <h5>Rizal St, Silay City, Neg. Occ.</h5>
                                        <h5>Tel. No. 495-1704 / 495-1705 / 495-0096</h5>
                                        <h4>HEMODIALYSIS PATIENT POPULATION RECORD</h4>
                                        </center>
                                        </div>
                                    </div>
                                
                                        <div>
                                                    <h4><br><br>
                                                        <p>
                                                        Date Entered The Dialysis: <?php echo $fetchp['P_Date']?><br>
                                                        Hospital ID: <?php echo $fetchp['Hospital_Id']?><br>
                                                        Patient Name: <?php echo $fetchp['P_Fname']." ".$fetchp['P_Mname']." ".$fetchp['P_Lname'] ?><br>
                                                        Nephrologist: <?php echo $fetchn['n_fname']." ".$fetchn['n_mname']." ".$fetchn['n_lname']?><br>
                                                        Diagnosis: <?php echo $fetchp['P_Diagnosis']?> <br>
                                                        Dialysis Schedule: <?php echo $fetchs['treatment_day']?>
                                                        Time: <?php echo $fetchs['treatment_time']?>    
                                                        </p>
                                                        
                                                    </h4>
                                                </div>
                                       
                                  <?php if($from != ''){?>
                                <b>Date: <u><?php echo $from." - ".$to?></u></b><br>
                                <?php } ?>
                                <b>Produced By: <u><?php echo $name ?></u></b>
                           
                            </div>
                                   <div class="row clearfix">
                                            <div class="col-lg-offset-10 col-xs-offset-10">
                                               <div class="row hidden-print mt-20">
                                                 
                                                   <a class="btn btn-primary btn-xs" onclick="printDiv('printableArea')" target="_blank"><i class="material-icons">print</i> Print</a>
                                                
                                                   
                                              </div>
                                         </div>
                                    </div>
                    
                         </div>
        <?php }?>
        <?php }?>
        
         
         

<script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
  <script src="../../../plugins/dropzone/dropzone.js"></script>

        <!-- Jquery Core Js -->
        <script src="../../../plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core Js -->
        <script src="../../../plugins/bootstrap/js/bootstrap.js"></script>

        <!-- Select Plugin Js -->
        <script src="../../../plugins/bootstrap-select/js/bootstrap-select.js"></script>

        <!-- Slimscroll Plugin Js -->
        <script src="../../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="../../../plugins/node-waves/waves.js"></script>


        <script src="../../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

        <script src="../../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>



        <!-- Jquery DataTable Plugin Js -->
        <script src="../../../plugins/jquery-datatable/jquery.dataTables.js"></script>
        <script src="../../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
         <script src="../../../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
        <script src="../../../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

        <!-- Custom Js -->
        <script src="../../../js/admin.js"></script>
        <script src="../../../js/pages/tables/jquery-datatable.js"></script>
        <script src="../../../js/pages/forms/advanced-form-elements1.js"></script>

        <!-- Demo Js -->
        <script src="../../../js/demo.js"></script>

      
    </body>
</html>