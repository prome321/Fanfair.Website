<?php


include ('config.php');


	if(isset($_GET['id']))
{
	
	$email = mysqli_real_escape_string($conn, $_GET['email']);	
	
		

	$query="SELECT * FROM signin WHERE email='{$email}' AND  isEmailConfirmed='0'";
	$result=mysqli_query($conn,$query);


	if($result)
	{
		if(mysqli_num_rows($result)>0)
	 		{
 			$result_fetch=mysqli_fetch_assoc($result);
				if($result_fetch['isEmailConfirmed']==0)
	 			{
	 				$update="UPDATE signin SET isEmailConfirmed='1', token='' WHERE email='{$email}'";
	 				if(mysqli_query($conn,$update))
					{
	 					echo"
					<script>
					alert('Email verification successful');
	 				window.location.href='signup.php';
					</script>
	 				";
	 				}
	 				else
					{
	 					echo"
						<script>
						alert('Can not run query');
	 					window.location.href='signup.php';
	 					</script>";
				}
				}
				else
	 			{
					echo"
	 				<script>
					alert('Email is already registered');
	 				window.location.href='signup.php';
 				</script>";
				}
			}

		}
	}
		else
		{
			echo"
 		<script>
			alert('Can not run query');
			window.location.href='signup.php';
			</script>";
	 	}

		
	
	
?>