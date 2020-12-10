<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ url('/') }}" target="_blank">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
<style>
body {font-family: 'Roboto', sans-serif; font-weight: 300}
#header {
    background: #ddd;
    min-height: 300px;
}
#logo {
    width:220px; 
    height: 220px;
    background: url('/img/logo.png') no-repeat;
    background-size:220px;
    margin: 0 auto 0 auto;
    text-align: center
}
#logo h2 {font-weight: bold; padding-top:210px;}
#logo span {font-weight: bold}
#footer {background: #aaa; min-height: 250px;}
#footer h3{text-align: center; padding-top: 100px; }
h1{font-weight: 500; margin: 20px 0 30px 0; text-align: center}
#main {border-left: 2px solid #ddd; border-right: 2px solid #ddd;}
table{font-weight: 500;}
</style>
</head>
<body>
    <div class="container" id="header">
        <div id="logo">
        <h2>Islamic Help</h2>
        <span>Empowering people in need</span>
        </div>
    </div>

    <div class="container pt-3 pb-5" id="main">
        <h1>Thank you for donation! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</h1>
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            Why do we use it?
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
        </p>

        <div class="pt-4 pb-3">
        <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="3">Total amount: <span class="text-danger">$300</span></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Donation</td>
                <td>Detail</td>
                <td>Donation amount</td>
              </tr>
              <tr>
                <td><span class="text-success">Single</span></td>
                <td><span class="text-success">Company</span></td>
                <td><span class="text-danger">$25</span></td>
              </tr>
            </tbody>
          </table>
        </div>

    </div>

    <div class="container" id="footer">
        <h3>Islamic help &copy; 2020</h3>
    </div>
</body>
</html>