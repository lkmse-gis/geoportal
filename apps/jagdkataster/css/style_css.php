<?php
header('Content-type: text/css');

?>

<style type="text/css">

.alert-box {
	color:#555;
	border-radius:10px;
	font-family:Tahoma,Geneva,Arial,sans-serif;font-size:11px;
	padding:10px 36px;
	margin:10px;
	}
	
.alert-box span {
	font-weight:bold;
	text-transform:uppercase;
	}
	
.error {
	background:#ffecec url('error.png') no-repeat 10px 50%;
	border:1px solid #f5aca6;
	}
	
.success {
	background:#e9ffd9 url('success.png') no-repeat 10px 50%;
	border:1px solid #a6ca8a;
	}
	
.warning {
	background:#fff8c4 url('warning.png') no-repeat 10px 50%;
	border:1px solid #f2c779;
	}
	
.notice {
	background:#e3f7fc url('notice.png') no-repeat 10px 50%;
	border:1px solid #8ed9f6;
	}

body{
margin: 0px;
padding: 0px;
border: 0;
color: #161414;
overflow: hidden;
height: 100%; 
max-height: 100%; 
font-family: "Arial",sans-serif;
font-size:14px;
text-align: center;
overflow: auto;
}

.table{
	width: 950px;
}

.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th
{
	border:1px solid #999;
}

.button {
    margin: 0px auto;
    text-decoration: none;
    font-family: "Arial",sans-serif;
    font-weight: bold;
    font-size: 120%;
    color: #161414;
    border-color: #768E1D;
    background: #DDEDA0;
    -moz-border-radius-bottomleft: 8px; /* Firefox */
    -webkit-border-radius-bottomleft: 8px; /* Safari, Chrome */
    -khtml-border-radius-bottomleft: 8px; /* Konqueror */
    -border-radius-bottomleft: 8px; /* CSS3 */
    -moz-border-radius-bottomright: 8px; /* Firefox */
    -webkit-border-radius-bottomright: 8px; /* Safari, Chrome */
    -khtml-border-radius-bottomright: 8px; /* Konqueror */
    -border-radius-bottomright: 8px; /* CSS3 */
    padding: 5px;
    padding-left: 93px;
    padding-right: 93px;
}

.button:hover {
    background: #cae469;
    text-decoration: none;
}

#framecontent{
position: absolute;
top: 0;
bottom: 0; 
left: 0;
width: 750px; /*Width of frame div*/
height: 100%;
overflow: hidden; /*Disable scrollbars. Set to "scroll" to enable*/
background: white;
color: color: #000000;;
} 

#maincontent{
position: fixed;
top: 0; 
left: 750px; /*Set left value to WidthOfFrameDiv*/
right: 0;
height: 100%;
bottom: 0;
overflow: auto; 
background: #fff;
}

.innertube{
margin: 15px; /*Margins for inner DIV inside each DIV (to provide padding)*/
height: 100%;

}

* html body{ /*IE6 hack*/
padding: 0 0 0 200px; /*Set value to (0 0 0 WidthOfFrameDiv)*/
}

* html #maincontent{ /*IE6 hack*/
height: 100%; 
width: 100%; 
}	

body
	{
	font-family: Arial; 
	font-size:14px;
	text-align: center;
	} 
	
h1
	{
	font-family: Arial; 
	font-size: 28px;
	text-align: center;
	}
	
h2
	{
	font-family: Arial; 
	font-size: 24px;
	text-align: center;
	}
	
h3
	{
	font-family: Arial; 
	font-size: 16px;
	text-align: center;
	background-color: lightsteelblue;
	border:1px solid;
	width:800px;
	margin-left:auto;
    margin-right:auto;
	page-break-inside: avoid;
	}
	
h4
	{
	font-family: Arial; 
	font-size: 16px;
	}
	
	
	
p
	{
	font-family: Arial; 
	text-align: center;
	font-weight:500;
	}
	
input 	
	{
	border:1px solid;
	font-weight:bold;
	}
	
select { 
	background-color: #ffFFFF; 
	font:Arial; 
	font-weightbold;
	font-size:14px;
	border:1px solid;
	#width:220px;
	vertical-align: middle;
	}

a
	{
	padding:5px;
	}
	
td  
    {
	font-family: Arial; 
	font-size:14px;
	text-align: center;
	} 
     
#kopf
	{
	margin-left:auto;
    margin-right:auto;
	width:800px;
	border:0px;
	
	}
	

#tdkopf1
	{
	font-family: Arial; 
	font-size: 16px;
	padding-left: 10px;
	
	}
	
#tdkopf2
	{
	font-family: Arial; 
	font-size: 10px;
	}
	
#tableauskunft
	{
	font-family: Arial;
	font-size:16px;
	margin-left:auto;
    margin-right:auto;
	width:800px;
	
	page-break-inside: avoid;
	}
	
#tableauskunft2
	{
	font-family: Arial;
	font-size:16px;
	width:100%;
	}	
	
#farbe_tab
	{
	border: 1px solid;
	border-color:#000000;
	border-collapse:separate;
	}
	
#tableinfo
	{
	font-family: Arial;
	text-align: center;
	color: #000000;
	font-size: 14px;
	border: 1px solid;
	border-collapse:collapse;
	border-spacing:0;
	padding: 2px;
	margin-left:auto;
    margin-right:auto;
	width:800px;
	page-break-inside: avoid;
	}
	
#trinfo
	{
	font-family: Arial;
	border:1px solid;
	color: #000000;
	border-collapse:collapse;
	border-spacing:0;
	}
	
#tdinfo
	{
	font-family: Arial;
	border:1px solid;
	color: #000000;
	border-collapse:collapse;
	border-spacing:0;
	}
	
#tdinfo1
	{
	font-family: Arial;
	color: #000000;
	border:0px solid;
	border-collapse:separate;
	border-spacing:1px;
	}

#tdinfo2
	{
	font-family: Arial;
	color: #000000;
	border:0px solid;
	border-collapse:separate;
	border-spacing:1px;
	}

#flauszug
	{
	page-break-before:auto;
	page-break-inside:avoid;
	border:1px solid;
	width:750;
	height:750;
	}
	
#flauszug2
	{
	page-break-before:avoid;
	page-break-inside:avoid;
	border:1px solid;
	width:800;
	height:800;
	}
	

option {font-size:14px;
font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
option:checked {background:#333333;}


#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 950px;
	
}

#customers td, #customers th {
    border: 1px solid #dddddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background: #333333;
	color: #ffffff;
	font-family: Arial; 
	}


@media print {
	#tableinfo_keinerg
	{display:none;}
	#tkopf_keinerg
	{display:none;}
	/*p
	{display:none;}*/

}
	
	
@media screen 
	{
#tableinfo_keinerg
	{
	font-family: Arial;
	text-align: center;
	font-size: 14px;
	color: #808080;
	border: 1px solid;
	border-collapse:collapse;
	border-spacing:0;
	border-color: #A9A9A9;
	padding: 2px;
	margin-left:auto;
    margin-right:auto;
	width:800px;
	page-break-inside: avoid;
	}
	
#tkopf_keinerg
	{
	background:lightgrey;
	border-color:#A9A9A9;
	text-align: left;
	margin-left: 10px;
	font-family: Arial; 
	font-size: 16px;
	color: #808080;
	padding-left: 10; 
	-webkit-border-top-left-radius: 6px;
	-webkit-border-top-right-radius: 6px;
	-moz-border-radius-topleft: 6px;
	-moz-border-radius-topright: 6px;
	border-top-left-radius: 6px;
	border-top-right-radius: 6px;
	-webkit-border-bottom-left-radius: 6px;
	-webkit-border-bottom-right-radius: 6px;
	-moz-border-radius-bottomleft: 0px;
	-moz-border-radius-bottomright: 0px;
	border-bottom-left-radius: 0px;
	border-bottom-right-radius: 0px;
	color: #000000;
	}
	}
	
.map{
	width:800px;
	height:800px;
	border:1px solid;
	z-index:1;
}

#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background-color:#fff;
  opacity:1;
  z-index:100;
}

#loading-text {
  display: block;
  position: absolute;
  top: 50%;
  left: 50%;
  color: #000;
  width: 100px;
  height: 30px;
  margin: -7px 0 0 -45px;
  text-align: center;
  font-size: 20px;
}

#loading-text-1 {
	color:#000;
width: 100%;
 position: absolute;
 top: 20%;
 -webkit-transform: translateY(-50%);
 -ms-transform: translateY(-50%);
 transform: translateY(-50%);
  font-family: 'PT Sans Narrow', sans-serif;
  font-size: 30px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 50%;
  width: 170px;
  height: 170px;
  margin: -85px 0 0 -85px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 3px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 5px solid transparent;
  border-top-color: #006085;
  border-bottom-color: #006085;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 5px solid transparent;
  border-top-color: #75b726;
  border-bottom-color: #75b726;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 5px solid transparent;
  border-top-color: #333;
  border-bottom-color: #333;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}	


</style>



