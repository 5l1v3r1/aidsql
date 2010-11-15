<?php

	namespace aidSQL\http {

		class Fuzzer {

			private	$_httpAdapter	=	NULL;
			private	$_log				=	NULL;

			public function __construct(\aidSQL\http\Adapter &$httpAdapter, \aidSQL\LogInterface &$log=NULL){

				$this->setHttpAdapter($httpAdapter);

				if(!is_null($log)){
					$this->setLog($log);
				}

			}

			public function setHttpAdapter(\aidSQL\http\Adapter &$httpAdapter){
				$this->_httpAdapter	=	$httpAdapter;
			}

			public function setLog(\aidSQL\LogInterface &$log){
				
				$this->_log = $log;

			}

			private function log($msg=NULL){
				
				if(!is_null($this->_log)){
					$this->_log->setPrepend('['.__CLASS__.']');
					call_user_func_array(array($this->_log, "log"),func_get_args());
					return TRUE;
				}

				return FALSE;

			}

			public function generate404($extension=NULL){

				$url	=	$this->_httpAdapter->getBaseUrl();

				$this->log("Trying to generate 404 (Not Found)",0,"white");
				$fakeUrl	=	"http://".$url."/".substr(md5(rand(1,time())),0,rand(0,32));

				if(!is_null($extension)){
					$fakeUrl.=$extension;
				}

				$this->log("Setting URL to $fakeUrl");

				$this->setUrl($fakeUrl);

				$result	=	FALSE;

				$this->fetch();

				$httpCode	=	$this->_httpAdapter->getHttpCode();

				if($httpCode>=400){

					$this->log("Got $httpCode :)",0,"light_cyan");
					$result = $this->parseError($this->_httpAdapter->fetch());
	
					if($result==FALSE){
						$this->log("Couldnt get any banner :(",2,"yellow");
					}

				}

				return array(
							"error"=>$result,
							"http_code"=>$httpCode
				);

			}

			public function generate414(){

				$url		=	$this->_httpAdapter->getBaseUrl();
				$result	=	FALSE;

				$this->log("Trying to generate 414 (URI Length Exceeded)",0,"white");

				$start	=	mt_rand(1,1000);

				while($start < 5000){

					$crap		=	\str_repeat("%00", $start);
					$start	+=	mt_rand(1,100);

					$fakeUrl	=	"http://".$url."/".$crap;
					$this->_httpAdapter->setUrl($fakeUrl);
					$this->log("Request length $start ...",0,"white");
					$this->_httpAdapter->fetch();

					$httpCode	=	$this->_httpAdapter->getHttpCode();

					if($httpCode>=400){

						$this->log("Got $httpCode :)!",0,"light_cyan");
						$result = $this->parseError($this->_httpAdapter->fetch());
						break;

					}

					$this->log("Got $httpCode instead of 414 :(",2,"yellow");

				}

				return array(
							"error"=>$result,
							"http_code"=>$httpCode
				);

			}

		}

	}

?>