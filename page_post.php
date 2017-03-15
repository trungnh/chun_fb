<html id="html" lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head id="ctl00_ctl00_Head1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<title>Facebook post tool - by Trung đẹp trai</title>
</head>
<?php 
ini_set("display_errors",1);
require_once __DIR__ . "/config.php";
?>
<body>
<form class="form-style-7" id="myForm" action="process.php" method="post">
	<div class="message">
		<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ""; ?>
	</div>
	<ul>
		<li>
			<label for="page_id">Choice Page</label>
			<select name="page_id[]" id="page_id" multiple>
				<?php foreach($page_data as $key => $page): ?>
				<option value="<?php echo $key; ?>"><?php echo $page['name']; ?></option>
				<?php endforeach; ?>
			</select>
			<span>Choice a page to post</span>
		</li>
		<li>
			<label for="picture">Image</label>
			<input type="text" name="picture" maxlength="200">
			<span>Enter link of image of post</span>
		</li>
		<li>
			<label for="link">Link</label>
			<input type="text" name="link" maxlength="200">
			<span>Link of post</span>
		</li>
		<li>
			<label for="name">Title</label>
			<input type="text" name="name" maxlength="200">
			<span>Enter title of post</span>
		</li>
		<li>
			<label for="message">Status</label>
			<textarea name="message" onkeyup="adjust_textarea(this)"></textarea>
			<span>Enter status of post</span>
		</li>
		<li>
			<label for="description">Description</label>
			<textarea name="description" onkeyup="adjust_textarea(this)"></textarea>
			<span>Description of post</span>
		</li>
		<li>
			<label for="source">Source</label>
			<input type="text" name="source" maxlength="200">
			<span>Enter title of post</span>
		</li>
		<li>
			<input type="submit" id="submit" value="Post This"/>
		</li>
	</ul>
</form>
<style type="text/css">
.success{color:green;}
.error{color:red;}
.form-style-7{
    max-width:650px;
    margin:50px auto;
    background:#fff;
    border-radius:2px;
    padding:20px;
    font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-7 h1{
    display: block;
    text-align: center;
    padding: 0;
    margin: 0px 0px 20px 0px;
    color: #5C5C5C;
    font-size:x-large;
}
.form-style-7 ul{
    list-style:none;
    padding:0;
    margin:0;   
}
.form-style-7 li{
    display: block;
    padding: 9px;
    border:1px solid #DDDDDD;
    margin-bottom: 30px;
    border-radius: 3px;
}
.form-style-7 li:last-child{
    border:none;
    margin-bottom: 0px;
    text-align: center;
}
.form-style-7 li > label{
    display: block;
    float: left;
    margin-top: -19px;
    background: #FFFFFF;
    height: 14px;
    padding: 2px 5px 2px 5px;
    color: #555;
    font-size: 14px;
    overflow: hidden;
    font-family: Arial, Helvetica, sans-serif;
}
.form-style-7 input[type="text"],
.form-style-7 input[type="date"],
.form-style-7 input[type="datetime"],
.form-style-7 input[type="email"],
.form-style-7 input[type="number"],
.form-style-7 input[type="search"],
.form-style-7 input[type="time"],
.form-style-7 input[type="url"],
.form-style-7 input[type="password"],
.form-style-7 textarea,
.form-style-7 select 
{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    display: block;
    outline: none;
    border: none;
    height: 25px;
    line-height: 25px;
    font-size: 16px;
    padding: 0;
    font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-7 input[type="text"]:focus,
.form-style-7 input[type="date"]:focus,
.form-style-7 input[type="datetime"]:focus,
.form-style-7 input[type="email"]:focus,
.form-style-7 input[type="number"]:focus,
.form-style-7 input[type="search"]:focus,
.form-style-7 input[type="time"]:focus,
.form-style-7 input[type="url"]:focus,
.form-style-7 input[type="password"]:focus,
.form-style-7 textarea:focus,
.form-style-7 select:focus 
{
}
#page_id{height:100px;}
.form-style-7 li > span{
    background: #F3F3F3;
    display: block;
    padding: 3px;
    margin: 0 -9px -9px -9px;
    text-align: center;
    color: #C0C0C0;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
}
.form-style-7 textarea{
    resize:none;
}
.form-style-7 input[type="submit"],
.form-style-7 input[type="button"]{
    background: #2471FF;
    border: none;
    padding: 10px 20px 10px 20px;
    border-bottom: 3px solid #5994FF;
    border-radius: 3px;
    color: #D2E2FF;
}
.form-style-7 input[type="submit"]:hover,
.form-style-7 input[type="button"]:hover{
    background: #6B9FFF;
    color:#fff;
}
</style>
<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}

/*$( "#submit" ).click(function( event ) { 
	// Stop form from submitting normally
	event.preventDefault();

	formData = $("#myForm").serialize();
	// Submit the form using AJAX.
	var abc = $.ajax({
		type: 'POST',
		url: "/fb/process.php",
		data: formData
	});
	
	abc.done(function(data){
		$(".message").html(data);
	});
});*/
</script>
</body>
</html>