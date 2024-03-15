<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <center><h4>Create an appointment</h4></center><br>
      <form class="form-group" method="post" action="admin-panel.php">
        <div class="row">
          <div class="col-md-4">
            <label for="spec">Specialization:</label>
          </div>
          <div class="col-md-8">
            <select name="spec" class="form-control" id="spec">
              <option value="" disabled="" selected="">Select Specialization</option>
              <option data-value="General">General</option>
              <option data-value="Cardiologist">Cardiologist</option>
              <option data-value="Pediatrician">Pediatrician</option>
              <option data-value="Neurologist">Neurologist</option>
            </select>
          </div>
          <br><br>
          <script>
            document.getElementById('spec').onchange = function foo() {
              let spec = this.value;   
              console.log(spec)
              let docs = [...document.getElementById('doctor').options];
              
              docs.forEach((el, ind, arr)=>{
                arr[ind].setAttribute("style","");
                if (el.getAttribute("data-spec") != spec ) {
                  arr[ind].setAttribute("style","display: none");
                }
              });
            };
          </script>

          <div class="col-md-4">
            <label for="doctor">Doctors:</label>
          </div>
          <div class="col-md-8">
            <select name="doctor" class="form-control" id="doctor" required="required">
              <option value="" disabled="" selected="">Select Doctor</option>
              <option value="ashok" data-value="500" data-spec="General">ashok</option>
              <option value="arun" data-value="600" data-spec="Cardiologist">arun</option>
              <option value="Dinesh" data-value="700" data-spec="General">Dinesh</option>
              <option value="Ganesh" data-value="550" data-spec="Pediatrician">Ganesh</option>
              <option value="Kumar" data-value="800" data-spec="Pediatrician">Kumar</option>
              <option value="Amit" data-value="1000" data-spec="Cardiologist">Amit</option>
              <option value="Abbis" data-value="1500" data-spec="Neurologist">Abbis</option>
              <option value="Tiwary" data-value="450" data-spec="Pediatrician">Tiwary</option>
            </select>
          </div><br><br> 

          <script>
            document.getElementById('doctor').onchange = function updateFees(e) {
              var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
              document.getElementById('docFees').value = selection;
            };
          </script>                  

          <div class="col-md-4">
            <label for="consultancyfees">Consultancy Fees</label>
          </div>
          <div class="col-md-8">
            <!-- <div id="docFees">Select a doctor</div> -->
            <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly">
          </div><br><br>

          <div class="col-md-4">
            <label>Date</label>
          </div>
          <div class="col-md-8">
            <input type="date" class="form-control datepicker" name="appdate">
          </div><br><br>

          <div class="col-md-4">
            <label>Time</label>
          </div>
          <div class="col-md-8">
            <input type="time" class="form-control" name="apptime">
          </div><br><br>

          <div class="col-md-4">
            <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-secondary">Update</button>
          </div>
          <div class="col-md-4"></div>                  
        </div>
      </form>
    </div>
  </div>
</div>
