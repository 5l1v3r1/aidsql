<?php

	$config = array(

		"url"=>array(
			"alias"=>'u',
			"required"=>TRUE
		),
		"plugins"=>array(
		),
		"http-method"=>array(
			"alias"=>"m",
			"values"=>array(
				"GET",
				"POST"
			)
		),
		"proxy-server"=>array(
			"requires"=>array("proxy-port")
		),
		"proxy-port"=>array(
			"requires"=>array("proxy-server")
		),
		"proxy-user"=>array(
			"requires"=>array("proxy-server")
		),
		"proxy-password"=>array(
			"requires"=>array(
				"proxy-server",
				"proxy-user"
			)
		),
		"proxy-auth"=>array(
			"values"=>array(
				"ntlm",
				"basic"
			),
			"requires"=>array(
					"proxy-server",
					"proxy-user",
					"proxy-password"
			)
		),
		"proxy-type"=>array(
			"values"=>array(
				"http",
				"socks5"
			),
			"requires"=>array("proxy-server")

		),
		"proxy-tunnel"=>array(
			"values"=>array(
				0,
				1
			),
			"requires"=>array("proxy-server")
		),
		"request-interval"=>array(
		),
		"http-adapter"=>array(
		),
		"proxy-file"=>array(
			"requires"=>array("proxy-server")
		),
		"urlvars"=>array(
			"requires"=>array("url")
		),
		"save-report"=>array(
			"alias"=>"s"
		),
		"verbose"=>array(
				  "novalue"=>TRUE
		),
		"immediate-mode"=>array(
			"values"=>array(
				"yes",
				"no"		
			)
		)
	);
?>
