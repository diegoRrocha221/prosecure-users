<?php 

function switch_accounts_email_template($title, $name, $subtitle, $content){

  $email_template = '
  <!DOCTYPE>
<html>
<head>
	<title>email</title>
	<style>
		.a_body {
			background-color: #25364D;
			color: #fff;
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 2rem;
			border: 1px solid #fff;
			border-radius: 10px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		}
		.logo {
			text-align: center;
			margin-bottom: 1rem;
		}
		.logo img {
			max-width: 200px;
		}
		.title {
			text-align: center;
			margin-bottom: 1rem;
			font-size: 2rem;
			font-weight: bold;
			color: #fff;
		}
		.intro {
			text-align: center;
			margin-bottom: 2rem;
			font-size: 1.2rem;
			color: #fff;
		}
		.section {
			margin-bottom: 2rem;
		}
		.section h2 {
			margin-top: 0;
			margin-bottom: 1rem;
			font-size: 1.5rem;
			font-weight: bold;
			color: #fff;
		}
		.section p {
			margin-bottom: 1rem;
			font-size: 1.1rem;
			color: #fff;
		}
		.section ul {
			margin-bottom: 0;
			padding-left: 0;
		}
		.section li {
			margin-bottom: 0.5rem;
			font-size: 1.1rem;
			color: #fff;
		}
		.section strong {
			font-weight: bold;
		}
	</style>
</head>
<body>
<div class="a_body">
	<div class="container">
		<div class="logo">
			<img src="https://www.prosecurelsp.com/images/logo.png" alt="LSP logo">
		</div>
		<div class="title">'.$title.'</div>
		<div class="intro">Hi '.$name.'!</div>
		<div class="section">
			<h2>'.$subtitle.'</h2>
			 '.$content.'
		</div>
	</div>
  </div>
</body>
</html>
  ';

  return $email_template;

}

?>