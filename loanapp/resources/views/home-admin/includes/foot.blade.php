<footer>
<script src="{{ URL::asset('public/assets/js/jquery-2.1.1.js') }}"></script>
<script src="{{ URL::asset('public/assets/js/bootstrap.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
		CKEDITOR.replace( 'description' );
		// CKEDITOR.replace( 'faq' );
		// CKEDITOR.replace( 'resources' );
		// CKEDITOR.replace( 'about' );
		// CKEDITOR.replace( 'contact_us' );

$(document).ready( function () {
$('#user-table').DataTable();

$('#rating-table').DataTable();

$('#personaldatatypes').DataTable();

$('#dsar-table').DataTable();


$('#appsdata-table').DataTable();



});


</script>

</footer>