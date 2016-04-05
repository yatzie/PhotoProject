    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- WYSIWYG text editor for photo edit page -->
    <script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Dropzone js plugin -->
    <script src="js/dropzone.js"></script>

    <!-- Google API Pie Chart -->
    <script type="text/javascript">
	  	google.charts.load('current', {'packages':['corechart']});
	  	google.charts.setOnLoadCallback(drawChart);
	  	function drawChart() {

	    	var data = google.visualization.arrayToDataTable([
	      		['Task', 'Percentage per Task'],
	      		['Views',     	<?php echo $session->count; ?>],
	      		['Comments',      <?php echo Comment::count_all(); ?>],
	      		['Users',  		<?php echo User::count_all(); ?>],
	      		['Photos', 	<?php echo Photo::count_all(); ?>]
	    	]);

		    var options = {
		      	pieSliceText: 'percentage',
		      	backgroundColor: 'transparent',
		      	legend: 'none'
		    };

		    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		    chart.draw(data, options);
	  	}
    </script>


</body>

</html>