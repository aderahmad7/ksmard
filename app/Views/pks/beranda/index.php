<?= $this->extend('template/body.php') ?>

<?= $this->section('content') ?>

<!-- Content -->
<style>
	th {
		font-size: 11pt;
	}

	td {
		font-size: 10pt;
	}
</style>
<div class="content-body">
	<!-- row -->
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-xl-8 col-sm-6">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Riwayat Indeks K Perusahaan</h4>
						<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('indeks_k_tahun', $tahun, '', 'id="indeks_k_tahun" class="nice-select default-select form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button  class="btn btn-primary" type="button" id="btn-filter-periode" onclick="getIndeksKData();"><i class="fa fa-filter" data-feather="filter"></i></button>
				</div>
					</div>
					<div class="card-body">
						<canvas id="indeksKChart"></canvas>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-sm-6">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Indeks K Provinsi</h4>
					</div>
					<div class="card-body">
						<canvas id="redial_indeks_k_prov"></canvas>
						<div class="mt-4 text-center">
							<h4 class="fs-20 font-w700"><?=$k_prov["indeks_k_provinsi"]==0?"Belum Ditetapkan":"Penetapan Bulan <br>".bulan($k_prov["indeks_k_provinsi_bulan"])." ".$k_prov["indeks_k_provinsi_tahun"];?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
					
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
let chart;
var dataRekap
getIndeksKData();
function getNamaBulanIndonesia(bulan) {
    const namaBulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return namaBulan[bulan - 1] || "Bulan tidak valid";
}
function renderChart(dataRekap,tahun) {
        const labels = dataRekap.map(item => getNamaBulanIndonesia(item.indkPeriodeBulan));
        const data = dataRekap.map(item => item.indkIndeksK);

        const ctx = document.getElementById('indeksKChart').getContext('2d');

        if (chart) {
            // update data jika chart sudah ada
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.data.datasets[0].label = 'Indeks K (%) Tahun '+tahun,
            chart.update();
        } else {
            // buat chart pertama kali
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Indeks K (%) Tahun '+tahun,
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
					plugins: {
					
						datalabels: {
							anchor: 'center',
							align: 'center',
							color: 'black',
							font: {
								weight: 'bold',
								size: 12
							},
							formatter: (value) => value !== null ? value : ''
						}
					},

                },
				plugins: [ChartDataLabels]
            });
        }
    } 
var donutOptions = {
  cutoutPercentage: 85, 
  legend: {position:'bottom', 
       labels:{pointStyle:'circle',
       usePointStyle:true}
  },
  
};
const centerLabel = {
        id: 'centerLabel',
        beforeDraw(chart, args, options) {
            const { ctx, chartArea: { width, height } } = chart;
            ctx.save();
            ctx.font = options.font || 'bold 28px sans-serif';
            ctx.fillStyle = options.color || '#000';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('<?=$k_prov["indeks_k_provinsi"];?>%', width / 2, height / 2);
        }
    };
var chDonutData1 = {
    //labels: ['Indeks K Provinsi', ''],
    datasets: [
      {
        backgroundColor: ['rgba(54, 162, 235, 0.6)','rgba(2, 2, 235, 0)'],
        borderWidth: 0,
        data: [<?=$k_prov["indeks_k_provinsi"]==0?0:$k_prov["indeks_k_provinsi"];?>, <?=$k_prov["indeks_k_provinsi"]==0?0:100-$k_prov["indeks_k_provinsi"];?>]
      }
    ]
};
var chDonut1 = document.getElementById("redial_indeks_k_prov");
if (chDonut1) {
  new Chart(chDonut1, {
      type: 'doughnut',
      data: chDonutData1,
      options: donutOptions,
	  plugins: [centerLabel]
  });
}

$(document).ready(function(){
});
	
$(window).on('load',function(){
	dlabSparkLine.load();
});

$(window).on('resize',function(){
	//dlabSparkLine.resize();
	setTimeout(function(){ dlabSparkLine.resize(); }, 1000);
});
function getIndeksKData() {

			$.ajax({
				url: "<?php echo base_url('pks/beranda/getIndeksK'); ?>",
				data: {
					indeks_k_tahun: $("#indeks_k_tahun").val()
				},
				type: "POST",
				dataType: 'JSON',
				success: function(response) {
					console.log(response)
					if (response.rekap) {
						dataRekap = response.data;
						renderChart(dataRekap,$("#indeks_k_tahun").val());	
					}
				}
			});
		}
</script>

<?= $this->endSection() ?>