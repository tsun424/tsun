<?php
/*
	163邮箱smtp发送，支持验证SMTP.
	由于各家邮箱对smtp实现可能不同，此类只在2016-02-01测试过163邮箱
	01-02-2016

*/

class Mail163{
	
	
	const CRLF = "\r\n";		//stop command
	
	private $smtpSocket;				//smtp socket
	private $paramArr;					//parameter array, including host,port,timeout,user name,password
	private $debug = false;				//set debug mode;
	
	
	public function __construct($paramArr){
		$this->paramArr = array();
		if(isset($paramArr['host'])){						//host information
			$this->paramArr['host'] = $paramArr['host'];
		}else{
			if($this->debug){
				echo "host is not set properly."."<br>";
			}
			return;
		}
		if(isset($paramArr['port'])){						//port
			$this->paramArr['port'] = $paramArr['port'];
		}else{
			if($this->debug){
				echo "port is not set properly."."<br>";
			}
			return;
		}
		if(isset($paramArr['timeout'])){					//timeout
			$this->paramArr['timeout'] = $paramArr['timeout'];
		}else{
			$this->paramArr['timeout'] = 10;
		}
		if(isset($paramArr['userName'])){					//user name
			$this->paramArr['userName'] = $paramArr['userName'];
		}else{
			if($this->debug){
				echo "user name is not set properly."."<br>";
			}		
			return;
		}
		//user password, here password must be 163 client authority password, not the password of 163 email account
		if(isset($paramArr['password'])){				
			$this->paramArr['password'] = $paramArr['password'];
		}else{
			if($this->debug){
				echo "password is not set properly."."<br>";
			}
			return;
		}
	}
	
	/*
		@param $mailType: 0 text/plain	1 text/html
	*/
	public function send($to,$subject='',$body = '',$mailType = 1){
		$toStr = "";
		if(!$this->connection()){
			if($this->debug){
				echo "connected failed."."<br>";
			}		
		}
		if(!$this->login()){
			if($this->debug){
				echo "login failed."."<br>";
			}
		}
		$res = $this->smtp_cmd("mail from:<".$this->paramArr['userName'].">");
		if(is_array($to)){
			$toStr = implode(",",$to);
			foreach($to as $mailto){
				$res = $this->smtp_cmd("rcpt to:<".$mailto.">");
			}
		}else{
			$toStr = $to;
			$res = $this->smtp_cmd("rcpt to:<".$to.">");
		}
		if($res == 250){
			$res = $this->smtp_cmd("data");
			if($res == 354){
				fputs($this->smtpSocket,"From:".$this->paramArr['userName']."\r\nTo:".$toStr."\r\nSubject:".$subject."\r\n");
				
				$boundary = uniqid("--BY_CHENALL_",true);
				$headers = "MIME-Version: 1.0"."\r\n";
				$headers .= "From: ".$this->paramArr['userName']."\r\n";
				$headers .= "Content-type: multipart/mixed; boundary= $boundary\n\n"."\r\n";//headers结束要至少两个换行
				fputs($this->smtpSocket,$headers);
				
				if($mailType == 1){
					$msg = "--$boundary\nContent-Type: text/html;charset=\"UTF-8\"\n\n";
				}else{
					$msg = "--$boundary\nContent-Type: text/plain;charset=\"UTF-8\"\n\n";
				}
				$msg .= $body;
				fputs($this->smtpSocket,$msg);
				
				//send the end identifier
				$res = $this->smtp_cmd("\n\r\n."."\r\n");
				if($res == 250){
					if($this->debug){
						echo "The email has been sent successfully."."<br>";
					}
					return true;
				}else{
					if($this->debug){
						echo "send email body failed. response code: ".$res."<br>";
					}
					return false;
				}

			}else{
				if($this->debug){
					echo "send data command error. response code: ".$res."<br>";
				}
				return false;
			}
		}else{
			if($this->debug){
				echo "send mail from and rcpt to error. response code: ".$res."<br>";
			}
			return false;
		}
		return true;
	}
	
	//connect to smtp server
	private function connection(){
		$this->smtpSocket = fsockopen($this->paramArr['host'], $this->paramArr['port'], $errno, $errstr, $this->paramArr['timeout']);
		if(!isset($this->smtpSocket) || empty($this->smtpSocket)){
			if($this->debug){
				echo "try to connect to smtp server failed."."<br>";
			}
			return false;
		}
		$res = intval(fgets($this->smtpSocket,512));
		if($res == 220){
			$res = $this->smtp_cmd('helo localhost');
			if($res != 250){
				if($this->debug){
					echo "error happened during say helo, messges from smtp server: ".$res."<br>";
				}
				return false;
			}
		}else{
			if($this->debug){
				echo "error happened during connect, messges from smtp server: ".$res."<br>";
			}
			return false;
		}
		if($this->debug){
			echo "connect smtp server successfully.<br>";
		}
		return true;
	}
	
	//do auth login
	private function login(){
		$res = $this->smtp_cmd("auth login");
		if($res == 334){
			$res = $this->smtp_cmd(base64_encode($this->paramArr['userName']));
			if($res == 334){
				$res = $this->smtp_cmd(base64_encode($this->paramArr['password']));
				if($res != 235){
					if($this->debug){
						echo "error happened during input password. ".$res."<br>";
					}
					return false;
				}
			}else{
				if($this->debug){
					echo "error happened during input user name. ".$res."<br>";
				}
				return false;
			}
		}else{
			if($this->debug){
				echo "error happened during auth login. ".$res."<br>";
			}
			return false;
		}
		return true;
	}
	
	
	//send command
	private function smtp_cmd($msg){
		$putRes = fputs($this->smtpSocket,$msg.self::CRLF);
		if($putRes){
			$res = fgets($this->smtpSocket,512);
			if($res){
				return intval($res);
			}else{
				if($this->debug){
					echo "get line from connection failed. error code: ".intval($res)."<br>";
				}
			}
		}else{
			if($this->debug){
				echo "put message to the server failed.<br>";
			}
		}
		return 0;
	}
	
	//disconnect all resources
	public function __destruct(){
		if($this->smtpSocket){
			fclose($this->smtpSocket);
		}
	}
	
}