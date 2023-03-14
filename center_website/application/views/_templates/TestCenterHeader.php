<html>
    <head>
        <title>University of Light</title>
        <link rel="icon" type="image/x-icon" href="http:\\127.0.0.1:8081\center_website\public\img\favicon.ico">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=News+Cycle&family=Old+Standard+TT:ital@1&display=swap');            
            header ul{
                display: flex;
                flex-direction: row;
                justify-content: space-around;
            }
            
            header li{
                list-style-type: none;
                padding: 10px;

            }
            header li:hover{
                box-sizing: border-box;
                border:2px solid white;
                border-radius: 15px;
                background-color: #055291;
                
            }
            header li:hover > a{
            color:white;
            font-size: 17px;

             }
             header li:hover >div>a{
            color:white;
             font-size: 17px;
         }
         header a{
                font-family: 'Cormorant Garamond', serif;
                text-decoration: none;
                color:white;
                font-size:22px;
                font-weight:bold;
         }
         header  #nav{
                width:30vw;
                margin: 0 auto;
                margin-top:0px;
            }

           header h1{
                color: white;
                font-weight: lighter;
                font-family: 'News Cycle', sans-serif;
                margin-top: 55px;
                margin-bottom: 0;
                height: 40px;
            }
            header h1:hover{
                text-shadow:1px 1px white ;
            }

            header{
                width: 100vw; height:170px;
                margin-left: 0;
                z-index: 999;
                background-color:#044980;
                margin-top:0;
                top:0;
                position: fixed;
                left:0;
            }
            header #logout{
                float: right;
                margin-right:30px;
                margin-top: 20px;
                border: 1px solid white;
                padding:12px;
                border-radius: 200px;
            }
            header #logout:hover{
                box-sizing: border-box;
                border:2px solid white;
                background-color: #055291;
                color:white;
                font-size: 17px;
            }
            header #logo{
                width:70px;
                height:70px;
                margin-top:30px;
                margin-left:20px;
                float:left;
            }
            @media (max-width: 800px) {
              /* For desktop: */
              header ul{
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                }
                header h1{
                
                color: white;
                font-weight: lighter;
                font-family: 'News Cycle', sans-serif;
                margin-top: 10px;
                margin-bottom: 5px;
                height: 10px;
                font-size:0;
                }
                header h1:hover{
                    text-shadow:1px 1px white ;
                }
                header a{
                    font-size:19.5px;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <img src="http:\\127.0.0.1:8081\center_website\public\img\logo.png" id="logo">
            <a href=<?php echo URL."home/logout" ?> id="logout"> Log out</a>
            <h1 style="display: inline-block;"> University of Light </h1>
            <nav id="nav">
            <ul>
                <li>
                    <a href=<?php echo URL."home/index"?> > Home </a> 
                </li>
                <li>
                    <a href=<?php echo URL."home/myAccount"?> > My Account </a>
                </li>
            </ul>
        </nav>
        </header>
    </body>
</html>