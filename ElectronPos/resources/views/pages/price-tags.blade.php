<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
body{margin-top:20px;}
@import url('https://fonts.googleapis.com/css?family=Abel');
html, body {
  background: #FCEEB5;
  font-family: Abel, Arial, Verdana, sans-serif;
}

.center {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
}

.card {
  width: 450px;
  height: 250px;
  background-color: #fff;
  background: linear-gradient(#f8f8f8, #fff);
  box-shadow: 0 8px 16px -8px rgba(0,0,0,0.4);
  border-radius: 6px;
  overflow: hidden;
  position: relative;
  margin: 1.5rem;
}

.card h1 {
  text-align: center;
}

.card .additional {
  position: absolute;
  width: 150px;
  height: 100%;
  background: linear-gradient(#dE685E, #EE786E);
  transition: width 0.4s;
  overflow: hidden;
  z-index: 2;
}

.card.green .additional {
  background: linear-gradient(#92bCa6, #A2CCB6);
}


.card:hover .additional {
  width: 100%;
  border-radius: 0 5px 5px 0;
}

.card .additional .user-card {
  width: 150px;
  height: 100%;
  position: relative;
  float: left;
}

.card .additional .user-card::after {
  content: "";
  display: block;
  position: absolute;
  top: 10%;
  right: -2px;
  height: 80%;
  border-left: 2px solid rgba(0,0,0,0.025);
}

.card .additional .user-card .level,
.card .additional .user-card .points {
  top: 15%;
  color: #fff;
  text-transform: uppercase;
  font-size: 0.75em;
  font-weight: bold;
  background: rgba(0,0,0,0.15);
  padding: 0.125rem 0.75rem;
  border-radius: 100px;
  white-space: nowrap;
}

.card .additional .user-card .points {
  top: 85%;
}

.card .additional .user-card svg {
  top: 50%;
}

.card .additional .more-info {
  width: 300px;
  float: left;
  position: absolute;
  left: 150px;
  height: 100%;
}

.card .additional .more-info h1 {
  color: #fff;
  margin-bottom: 0;
}

.card.green .additional .more-info h1 {
  color: #224C36;
}

.card .additional .coords {
  margin: 0 1rem;
  color: #fff;
  font-size: 1rem;
}

.card.green .additional .coords {
  color: #325C46;
}

.card .additional .coords span + span {
  float: right;
}

.card .additional .stats {
  font-size: 2rem;
  display: flex;
  position: absolute;
  bottom: 1rem;
  left: 1rem;
  right: 1rem;
  top: auto;
  color: #fff;
}

.card.green .additional .stats {
  color: #325C46;
}

.card .additional .stats > div {
  flex: 1;
  text-align: center;
}

.card .additional .stats i {
  display: block;
}

.card .additional .stats div.title {
  font-size: 0.75rem;
  font-weight: bold;
  text-transform: uppercase;
}

.card .additional .stats div.value {
  font-size: 1.5rem;
  font-weight: bold;
  line-height: 1.5rem;
}

.card .additional .stats div.value.infinity {
  font-size: 2.5rem;
}

.card .general {
  width: 300px;
  height: 100%;
  position: absolute;
  top: 0;
  right: 0;
  z-index: 1;
  box-sizing: border-box;
  padding: 1rem;
  padding-top: 0;
}

.card .general .more {
  position: absolute;
  bottom: 1rem;
  right: 1rem;
  font-size: 0.9em;
}
.img-thumbnail{
    width:110px;
    height:110px;
    margin-top: 50%;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/jspdf"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function () {
      $("#exportToPdf").on("click", function () {
          console.log('Export button clicked');
          // Select the container element that holds all the cards
          var container = document.getElementById('cardContainer');

          // Use html2canvas to capture the container as an image
          html2canvas(container, {
              onrendered: function(canvas) {
                  // Convert the canvas image to PDF using jspdf
                  var imgData = canvas.toDataURL('image/png');
                  var pdf = new jsPDF();
                  pdf.addImage(imgData, 'PNG', 0, 0, 210, 297); // A4 size: 210mm × 297mm
                  pdf.save("MyTags.pdf");
              }
          });
      });
  });
</script>
<button class="btn btn-info text-center" id="exportToPdf">Export To Pdf</button>
<div id="cardContainer" class="center">
    @foreach ($products as $product)
    <div class="card" style="border:1px dashed #000;margin-top:100px;">
        <div class="general">
            <h1 class="text-center">{{ $product->name }}</h1>
            <div class="">
                {!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!}
            </div>
            <h1 class="text-center">{{ $product->price }}</h1>
        </div>
    </div>
    @endforeach
</div>