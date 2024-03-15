<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
</head>
<body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;">WELCOME RECEPTIONIST</h3>
    <div class="row">
      <div class="col-md-4" style="max-width:25%;margin-top: 3%;">
        <div class="list-group" id="list-tab" role="tablist">
          <!-- Existing sidebar items -->
          <!-- Add a new list item for "Manage Appointments" -->
          <a class="list-group-item list-group-item-action" href="#list-app-manage" id="list-app-manage-list" role="tab" data-toggle="list" aria-controls="home">Manage Appointments</a>
        </div>
        <br>
      </div>
      <div class="col-md-8" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">
          <!-- Existing tab-panes -->
          <!-- Add a new tab-pane for "Manage Appointments" -->
          <div class="tab-pane fade" id="list-app-manage" role="tabpanel" aria-labelledby="list-app-manage-list">
            <!-- Content for "Manage Appointments" tab-pane -->
            <!-- Add your content here -->
            <h4>Manage Appointments Content</h4>
            <!-- Your content goes here -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
