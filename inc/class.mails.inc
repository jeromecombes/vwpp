<?php
require_once "phpmailer/class.phpmailer.php";

class vwppMail{
  public $doctype="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
  public $body=null;
  public $subject=null;
  public $head=null;
  public $message=null;
  public $address=array();
  public $CCAddress=array();
  public $error=null;
  public $from=null;
  public $fromName=null;
  public $sender=null;

  public function createHeader(){
    $head="<html><head>\n";
    $head.="<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";
    $head.="<title>{$this->subject}</title></head>\n<body>\n\n";
    $this->head=$head;
  }

  public function createFooter(){
    $this->footer="</body></html>";
  }

  public function createBody(){
    $this->createHeader();
    $this->createFooter();
    $this->message=$this->doctype;
    $this->message.=$this->head;
    $this->message.=$this->body;
    $this->message.=$this->footer;
  }

  public function AddAddress($address){
    $this->address[]=$address;
  }

  public function AddCC($address){
    $this->CCAddress[]=$address;
  }

  public function send(){
    $this->createBody();

    $mail=new PHPMailer();

    if($GLOBALS['config']['Mail-IsMail-IsSMTP']=="IsMail")
      $mail->IsMail();
    else
      $mail->IsSMTP();
    
    $mail->WordWrap =$GLOBALS['config']['Mail-WordWrap'];
    $mail->Hostname =$GLOBALS['config']['Mail-Hostname'];
    $mail->Host =$GLOBALS['config']['Mail-Host'];
    $mail->Port =$GLOBALS['config']['Mail-Port'];
    $mail->SMTPSecure = $GLOBALS['config']['Mail-SMTPSecure'];
    $mail->SMTPAuth =$GLOBALS['config']['Mail-SMTPAuth'];
    $mail->Username =$GLOBALS['config']['Mail-Username'];
    $mail->Password =$GLOBALS['config']['Mail-Password'];
    $mail->From =$this->from?$this->from:$GLOBALS['config']['Mail-From'];
    $mail->FromName =$this->fromName?$this->fromName:$GLOBALS['config']['Mail-FromName'];
    $mail->Sender =$this->sender?$this->sender:$GLOBALS['config']['Mail-Sender'];
    $mail->CharSet=$GLOBALS['config']['Mail-CharSet'];
    $mail->IsHTML();

    $mail->Body = $this->message;
    foreach($this->address as $elem)
      $mail->AddAddress($elem);

    foreach($this->CCAddress as $elem)
      $mail->AddCC($elem);

    $mail->Subject=$this->subject;
    $mail->Send();
    $this->error=$mail->ErrorInfo;
  }

}

?>