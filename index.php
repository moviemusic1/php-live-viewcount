<?php 
	session_start();

	function hashed($length) {
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$crypto_rand_secure = function ($min, $max) {
			$range = $max - $min;
			if ($range < 0) return $min; // not so random...
			$log = log($range, 2);
			$bytes = (int) ($log / 8) + 1; // length in bytes
			$bits = (int) $log + 1; // length in bits
			$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ($rnd >= $range);
			return $min + $rnd;
		};

		$token = "";
		$max = strlen($pool);
		for($i=0;$i<$length;$i++) {
			$token .= $pool[$crypto_rand_secure(0,$max)];
		}
		return $token;
	}

	if(!isset($_COOKIE["viewcount_userid"])) {
		setcookie("viewcount_userid", hashed(12), time() + (86400 * 365.25));
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>View count by moviemusic1</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<center>
	<div class="wrapper">
		<div class="content">
			<div class="center">
				<noscript>
					<div class="js-activate">
						<p>Please activate JavaScript to make this page work!</p>
					</div>
				</noscript>
				<div class="watchingdiv">
					<h4 class="usercount_div"><span class="usercounter">0</span> people watching this page right now!</h4>
				</div>
			</div>
		</div>
	</div>
	</center>

	<script src="js/jquery.min.js"></script>
	<script type="text/javascript">
		setInterval(function() {
			updatecount();
		}, 10000);
		updatecount();
		function updatecount() {
			$.post("includes/updatecount.inc.php", {
				request: "update"
			});
			$.ajax({
				type: "POST",
				data: "get",
				datatype: "html",
				url: "includes/getcount.inc.php",
				success: function(data) {
					document.querySelector('.usercounter').innerHTML = data;
				},
				error: function(err) {
					alert("Error: " + err);
				}
			});
		};
	</script>
</body>
</html>