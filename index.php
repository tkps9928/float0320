﻿<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理</title>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($conf['EasyFlowServer']);

if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {

        // 參數設定
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $eid = $_POST['eid'];
        $user = $_POST['user'];
        $dep = $_POST['dep'];
        $Date1  = $_POST['Date1'];
        $Date2  = $_POST['Date2'];
        $Date3  = $_POST['Date3'];
        $Time2  = $_POST['Time2'];
        $Time3  = $_POST['Time3'];
        $RadioButton0 = $_POST['RadioButton0'];
        $RadioButton1 = $_POST['RadioButton1'];
        $msg = $_POST['msg'];
        

		
        // 送到流程管理
        try{
            $procesesStr = $client->findFormOIDsOfProcess($oid);

            $proceses = explode(",", $procesesStr);
            $process = $proceses[0];
            $template = $client->getFormFieldTemplate($process);

            $form = simplexml_load_string($template);
        
            $form->Textbox0 = $dep ;
            $form->Textbox1 = $user ;
            $form->Date1 = $Date1 ;
            $form->Date2 = $Date2 ;
            $form->Date3 = $Date3 ;
            $form->Time2 = $Time2 ;
            $form->Time3 = $Time3 ;
            $form->RadioButton0 = $RadioButton0;
            $form->RadioButton1 = $RadioButton1;
            $form->TextArea0 = $msg;
            $result = $form->asXML();
            $client->invokeProcess($oid, $eid, $uid, $process, $result, "伺服器代管申請作業");
        }catch(Exception $e){
        echo $e->getMessage();
        }

    } else {
        echo "系統錯誤";
    }
    
}

?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          

          <div class="row">
          <div class="col-md-5 mb-3">
                  <label for="uid">申請單位編號</label>
                  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                  申請單位編號 必填
                  </div>
              </div>
              <div class="col-md-1 mb-3">
              
              </div>
              <div class="col-md-5 mb-3">
              <label for="uid">申請單位</label>
                  <input name="dep" type="text" class="form-control" id="dep" placeholder="" value="" required>
                  <div class="invalid-feedback">
                  申請單位 必填
                  </div>
              </div>
          </div>

          <div class="row">

          <div class="col-md-5 mb-3">
          <label for="eid">申請人/分機編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
              申請人/分機編號 必填
              </div>
              </div>
              <div class="col-md-1 mb-3">
             
              </div>
              <div class="col-md-5 mb-3">
              <label for="user">申請人/分機</label>
                  <input name="user" type="text" class="form-control" id="user" placeholder="" value="" required>
                  <div class="invalid-feedback">
                  申請人/分機 必填
                  </div>
              </div>

            
          </div>

          <div class="row">
              <div class="col-md-11 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-11 mb-3">
                  <label>申請日期</label>
                  <input type="date" name="Date1"  class="form-control">
                </div>
          </div>
          
          <label>刊登時間</label><br>
          <div class="row">
              <div class="col-md-5 mb-3">
                  <input type="date" name="Date2"  class="form-control">
                  <input type="time" name="Time2"  class="form-control">
              </div>
              <div class="col-md-1 mb-3">
              <label-align="center">至</label>
              </div>
              <div class="col-md-5 mb-3">
                  <input type="date" name="Date3"  class="form-control">
                  <input type="time" name="Time3"  class="form-control">
              </div>
          </div>

          <div class="row">
			  <div class="col-md-12 mb-3">
				  <label >申請事項 </label><br>
				  <label ><input name="RadioButton0" type="Radio" value="1" >Banner(1004x300像素)</label >
				  <label ><input name="RadioButton0" type="Radio" value="2" >跑馬燈</label >
				  <label ><input name="RadioButton0" type="Radio" value="3" >快速連結</label >
				  <label ><input name="RadioButton0" type="Radio" value="4" >網頁內容</label >
				  <label ><input name="RadioButton0" type="Radio" value="5" >網頁版面</label >
				  <label ><input name="RadioButton0" type="Radio" value="6" >增建帳號</label >
				  <label ><input name="RadioButton0" type="Radio" value="7" >其他</label >
          </div>
          </div>

<div class="row">
			  <div class="col-md-12 mb-3">
				  <label >協助事項 </label><br>
				  <label ><input name="RadioButton1" type="Radio" value="1" >新增</label >
				  <label ><input name="RadioButton1" type="Radio" value="2" >修改</label >
				  <label ><input name="RadioButton1" type="Radio" value="3" >刪除</label>
          </div>
          </div>

          <div class="row">
			  <div class="col-md-12 mb-3">
        <label >申請注意事項說明 </label><br>
          <textarea name="msg" style="width:400px;height:120px;"></textarea><br>
          </div>
          </div>

          <div class="row">
			  <div class="col-md-12 mb-3">
        <label >注意事項</label><br>
				  1. 申請事項說明以簡單扼要為原則。<br>
				  2. 申請單位應負刊登文字責任。<br>
				  3. 相關檔案請寄到公務信箱banner：bcoffice01@nkust.edu.tw (請在刊登日前3天寄出)。<br>
				  其他： chunting@nkust.edu.tw<br>
          </div>
          </div>
			
			
			
				
          
				  
				</div>
			</div>
      
          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>