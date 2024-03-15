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


<script>
    document.getElementById('doctor').onchange = function updateFees(e) {
      var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
      document.getElementById('docFees').value = selection;
    };
</script>  