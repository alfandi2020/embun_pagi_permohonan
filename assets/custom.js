
  

$(function() {
    $('a').filter(function() {
        return this.href == location.href
    }).parent().addClass('active').siblings().removeClass('active')
})

// for sidebar menu entirely but not cover treeview
$('ul.navigation .nav-item a').filter(function() {
    return this.href == location.href
}).parent().addClass('active');

// for treeview
$('ul.nav-collapse li a').filter(function() {
    return this.href == location.href
}).parentsUntil(".nav > .nav.nav-collapse li a").addClass('active');

$('div.collapse li a').filter(function() {
    return this.href == location.href
}).parentsUntil(".nav > collapse li a").addClass('show');

$(document).ready( function () {
    $('#table_permohonan thead tr').clone(true).appendTo( '#table_permohonan thead' );
    $('#table_permohonan thead tr:eq(1) th').each( function (i) {
        if(i == 0 || i >= 10) $(this).html('-');
        if(i > 0 && i < 10){
            if (i === 3) {
                $(this).html('<input type="date" style="width: 95%" placeholder="" name="ser'+ i +'" class="ser" id="ser'+ i +'" />');
            }else{
                $(this).html('<input type="text" style="width: 95%" placeholder="" name="ser'+ i +'" class="ser" id="ser'+ i +'" />');
            }
        }
        $( 'input', this ).on( 'input', function () {
            if ( table_bdh.columns(i).search() !== this.value ) {
                table_bdh.columns(i).search( this.value ).draw();
            }
        });
    });

    table_bdh = $('#table_permohonan').DataTable({
        /*"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],*/
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + "permohonan/get_list_permohonan",
            "type": "POST",
            "data": function (data) {
                    data.nama_pemohon = $('#ser1').val();
                    data.no_permohonan = $('#ser2').val();
                    data.tgl_permohonan = $('#ser3').val();
                    data.status = $('#ser4').val();
            }
        },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": true
            }
        ],
        "orderCellsTop": true,
        "fixedHeader": true,
        fnDrawCallback:function (oSettings) {
            console.log("after table create");
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
        }
    });
} );


var max_fields = 100;
    var wrapper = $("#permohonan-wrapper");
    var add_kom = $("#add-permohonan");
    var x = 1;
    $(add_kom).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(
                '<div>'+
                '<div class="mb-3">' +
                '<div class="row">' +
                '<div class="col-md-4 col-sm-12 col-xs-12">' +
                '<label for="exampleFormControlInput1" class="form-label">ISI Pengajuan</label>' +
                '<input required type="text" class="form-control"  name="isi' + x + '" value="" placeholder="Pengeluaran" required>' +
                '</div>' +
                '<div class="col-md-3 col-sm-3 col-xs-3">' +
                '<label for="exampleFormControlInput1" class="form-label">Nominal</label>' +
                '<input required type="text" id="rupiah'+x+'" class="form-control" name="nominal' + x + '" placeholder="1.000.000" value="">' +
                '</div>' +
                '<div class="col-md-3 col-sm-3 col-xs-3 mt-4">' +
                '<button class="btn btn-danger remove_sampel"><i class="tf-icons bx bx-minus"></i></button>'+
                '</div>' +
                '</div>' +
               
                '<input type="hidden" id="id' + x + '" name="id' + x + '" value="' + x + '">' +
                '<input type="hidden" id="row' + x + '" name="row[]" value="' + x + '">' +
                '</div>'+
                '</div>'
            );

        }
        var rupiah = document.getElementById('rupiah'+x);
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value, 'Rp. ');
		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
		}
    });
    $(wrapper).on("click",".remove_sampel", function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); x--;
    });

  
  