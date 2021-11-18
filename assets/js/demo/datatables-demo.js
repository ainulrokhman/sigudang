$(document).ready(function() {
  var datatable = $('#dataTable').DataTable( {
      "processing": true,
      "serverSide": true,
      'order' : [],
      // 'data' : getdata,
      "ajax": {
        'url' : "http://localhost/formapp/transaksi/ajax",
        'type' : 'POST',
      },
      "lengthMenu": [[25, 50, 100, -1], ["25 Baris", "50 Baris", "100 Baris", "Tampil Semua"]],
      dom: 'Bfrtip',
      buttons: [
          'copy', 'excel', 'print', 'pageLength'
      ]
  } );

  $('#tanggal').datepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#tanggal').on('change', function() {
    let val = this.value;
    let x = moment(new Date(val)).format('YYYY-MM-DD');
    datatable.ajax.url('http://localhost/formapp/transaksi/ajax?filter=' + x).load();
  })
} );