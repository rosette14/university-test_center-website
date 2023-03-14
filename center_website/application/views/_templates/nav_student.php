<html>
<head>
    <script>
      $('li').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
      });
    </script>
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Roboto+Mono:wght@100&display=swap');
          </style> 
    <style>
    * {
       box-sizing: border-box;
      }
    .nav-container {
      left:0;
      top:170px;
      position: fixed; 
      height:100%;
      width: 300px;
      background-color: rgb(22, 39, 78);
      transition: all 0.5s linear;
      z-index: 100;
    }
    .nav-container .nav {
      height:100%;
      list-style-type: none;
      margin:0;
      padding:0;
    }
    .nav-container li{
      height: 65px;
      position:relative;
    }
    .nav-container a {
      border-top: 1px solid rgba(255,255,255,0.1);
      border-bottom: 1px solid black;
      text-decoration: none;
      display:block;
      padding:5px;
      height:100%;
      width:100%;
      font-size:19px;
      font-family: 'PT Sans', monospace;
      line-height:50px;
      color:#bbb;
      font-weight: bold;
      padding-left:15%;
      border-left: 5px solid transparent;
      letter-spacing: 1px;
      transition:all 0.3s linear;
    }
    .nav-container .text {
      transition: all .4s linear;
    }
    .nav-container li:hover .text{
     margin-left:20px
    }
    .nav-container .active a {
      color:rgb(156, 195, 226);
      border-left:5px solid rgb(156, 195, 226);
      background-color: #1a1a27;
      outline:0;
    }
    .nav-container li:not(.active):hover a{
      color: #eee;
      border-left:5px solid #FCFCFC;
      background-color: #1B1B1B;
    }
    .nav-container span[class ^= "icon"]{
      position:absolute;
      left:20px;
      font-size:1.5em;
      transition: all 0.3s linear;
    }
    @media only screen and (max-width : 860px){
      .text{
        display:none;
        max-width : 860px
      }
      .nav-container, a {
        width: 70px;
      }
      .nav-container a:hover{
        width: 200px;
        z-index:1;
        border-top: 1px solid rgba(255,255,255,0.1);
        border-bottom: 1px solid black;
        box-shadow: 0 0 1px 1px black;
      }
      .nav-container a:hover .text {
        display:block;
        padding-left: 30%;    
      }
    }
    </style>
</head>
<body>
<div class="nav-container" id="nav-container">
  <ul class="nav">
    <li class="Home" id="Home">
    <a href="<?php echo URL.'home/index' ?>">
        <span class="text">Home</span>
      </a>
    </li>
    <li class="takeTest" id="takeTest" >
      <a href=<?php echo URL."students/chooseMaterial"; ?>  >
        <span class="text">Take a Test </span>
      </a>
    </li>
    <li class="showResults" id="showResults">
      <a href=<?php echo URL."students/showResults"; ?> >
          <span class="text">My Results</span>
      </a>
    </li>
  </ul>
</div>

</body>
</html>