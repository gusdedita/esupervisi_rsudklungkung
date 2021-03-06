<?PHP
	include("configdb.php");
	
	require_once ("assets/fpdf/fpdf.php");
	date_default_timezone_set('Asia/Singapore');
	$datenow  = date('y-m-d');
	
	$super_tanggal = $_GET['tanggal'];
	$super_jadwal  = $_GET['jadwal'];
	//Inisiasi untuk membuat header kolom
	$column_no 			   = "";
	$column_namaruangan	   = "";
	$column_kapasitas      = "";
	$column_nonkelas       = "";
	$column_ksatu    	   = "";
	$column_kdua     	   = "";
	$column_ktiga     	   = "";
	$column_rujuk     	   = "";
	$column_meninggal 	   = "";
	
	
	//Create a new PDF file
	$pdf = new FPDF('L','mm',array(210,297)); //L For Landscape / P For Portrait
	$pdf->AddPage();
	//Menambahkan Gambar
	//$pdf->Image('../foto/logo.png',10,10,-175);
	
	
	$pdf->Image('assets/img/logo-pemkab.png',30,10,-1700);
	$pdf->Image('assets/img/logo-bulat.png',240,10,-250);
	$pdf->SetY(13);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(80);
	$pdf->Cell(120,7,'LAPORAN SUPERVISI KEPERAWATAN',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(80);
	$pdf->Cell(120,7,'BIDANG KEPERAWATAN RSUD KABUPATEN KLUNGKUNG',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(80);
	$pdf->Cell(120,7,'Tanggal : '.$super_tanggal.'        Jadwal Supervisi: '.$super_jadwal,0,0,'C');
	$pdf->Ln();
	$pdf->Line(20,40,270,40);
	
	
	//Fields Name position
	$Y_Fields_Name_position = 45;
	//First create each Field Name
	//Gray color filling each Field Name box
	$pdf->SetFillColor(200,150,300);
	//Bold Font for Field Name
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY($Y_Fields_Name_position);
	$pdf->SetX(15);
	$pdf->Cell(15,16,'No.',1,0,'C',1);
	$pdf->SetX(30);
	$pdf->Cell(40,16,'Nama Ruang',1,0,'C',1);
	$pdf->SetX(70);
	$pdf->Cell(20,16,'Kapasitas',1,0,'C',1);
	$pdf->SetX(90);
	$pdf->Cell(80,8,'Terisi',1,0,'C',1);
	
	$pdf->SetX(170);
	$pdf->Cell(20,16,'Dirujuk',1,0,'C',1);
	$pdf->SetX(190);
	$pdf->Cell(20,16,'Meninggal',1,0,'C',1);
	
	
	$pdf->SetY(53);
	$pdf->SetX(90);
	$pdf->Cell(20,8,'Non Kelas',1,0,'C',1);
	$pdf->SetX(110);
	$pdf->Cell(20,8,'Kelas I',1,0,'C',1);
	$pdf->SetX(130);
	$pdf->Cell(20,8,'Kelas II',1,0,'C',1);
	$pdf->SetX(150);
	$pdf->Cell(20,8,'Kelas III',1,0,'C',1);
	$pdf->Ln();
	
	
	//Table position, under Fields Name
	$Y_Table_Position = 61;
	//Now show the columns
	$pdf->SetFont('Arial','',10);
	$pos_no = 15;
	
	$qu_selsuper=mysql_query("SELECT * FROM supervisi_pasien WHERE tgl_supervisi='$super_tanggal' AND jadwal_supervisi='$super_jadwal'") or die(mysql_error());
	$no_selsuper=1;
	
	while($data_selsuper = mysql_fetch_array($qu_selsuper)){
		
		$namaruangan = $data_selsuper['nama_unit'];
		$kapasitas   = 0;
		$jumnonkls   = $data_selsuper['jum_umum'] + $data_selsuper['jum_jkn'];
		$jumsatu     = $data_selsuper['jum_umum_i'] + $data_selsuper['jum_jkn_i'];
		$jumdua 	 = $data_selsuper['jum_umum_ii'] + $data_selsuper['jum_jkn_ii'];
		$jumtiga	 = $data_selsuper['jum_umum_iii'] + $data_selsuper['jum_jkn_iii'];
		$jumrujuk	 = $data_selsuper['rujuk_umum'] + $data_selsuper['rujuk_jkn'];
		$jumeninggal = $data_selsuper['meninggal_umum'] + $data_selsuper['meninggal_jkn'];
		
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(15);
		$pdf->MultiCell(15,6,$no_selsuper,1,'C');
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(30);
		$pdf->MultiCell(40,6,$namaruangan,1,'L');
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(70);
		$pdf->MultiCell(20,6,$kapasitas,1,'C');
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(90);
		$pdf->MultiCell(20,6,$jumnonkls,1,'C');
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(110);
		$pdf->MultiCell(20,6,$jumsatu,1,'C');
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(130);
		$pdf->MultiCell(20,6,$jumdua,1,'C');
		
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(150);
		$pdf->MultiCell(20,6,$jumtiga,1,'C');
		
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(170);
		$pdf->MultiCell(20,6,$jumrujuk,1,'C');
		
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(190);
		$pdf->MultiCell(20,6,$jumeninggal,1,'C');
		
		$no_selsuper++;
		$Y_Table_Position = $Y_Table_Position + 6;
		
	
	}
	
	$pdf->SetY(400);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(80);
	$pdf->Cell(120,7,'LAPORAN PERMASALAHAN',0,0,'C');
	
	$pdf->SetFillColor(200,150,300);
	
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(20);
	$pdf->SetX(5);
	$pdf->Cell(10,16,'No.',1,0,'C',1);
	$pdf->SetX(15);
	$pdf->Cell(35,16,'Nama Ruang',1,0,'C',1);
	$pdf->SetX(50);
	$pdf->Cell(80,8,'Bid. Medis',1,0,'C',1);
	$pdf->SetX(130);
	$pdf->Cell(80,8,'Bid. Penunjang Pelayanan',1,0,'C',1);
	$pdf->SetX(210);
	$pdf->Cell(80,8,'Bid. Adm Umum',1,0,'C',1);
	
	$pdf->SetY(28);
	$pdf->SetX(50);
	$pdf->Cell(40,8,'Masalah',1,0,'C',1);
	$pdf->SetX(90);
	$pdf->Cell(40,8,'Tanggapan',1,0,'C',1);
	$pdf->SetX(130);
	$pdf->Cell(40,8,'Masalah',1,0,'C',1);
	$pdf->SetX(170);
	$pdf->Cell(40,8,'Tanggapan',1,0,'C',1);
	$pdf->SetX(210);
	$pdf->Cell(40,8,'Masalah',1,0,'C',1);
	$pdf->SetX(250);
	$pdf->Cell(40,8,'Tanggapan',1,0,'C',1);
	
	$pdf->Ln();
	
	$Y_pos = 36;
	
	//$pdf->SetFont('Arial','',10);
	$no_selmas=1;
	$qu_selmas=mysql_query("SELECT * FROM supervisi_pasien AS sp JOIN supervisi_masalah AS sm ON sp.id_supervisi=sm.id_supervisi WHERE tgl_supervisi='$super_tanggal' AND jadwal_supervisi='$super_jadwal'") or die(mysql_error());
	while($data_selmas = mysql_fetch_array($qu_selmas)){
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(5);
		$pdf->MultiCell(10,6,$no_selmas,1,'C');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(15);
		$pdf->MultiCell(35,6,$data_selmas['nama_unit'],1,'C');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(50);
		$pdf->MultiCell(40,6,$data_selmas['masalah_medis'],1,'L');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(90);
		$pdf->MultiCell(40,6,$data_selmas['tanggapan_medis'],1,'L');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(130);
		$pdf->MultiCell(40,6,$data_selmas['masalah_pelayanan'],1,'L');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(170);
		$pdf->MultiCell(40,6,$data_selmas['tanggapan_pelayanan'],1,'L');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(210);
		$pdf->MultiCell(40,6,$data_selmas['masalah_umum'],1,'L');
		
		$pdf->SetY($Y_pos);
		$pdf->SetX(250);
		$pdf->MultiCell(40,6,$data_selmas['tanggapan_umum'],1,'L');
		
		
		$no_selmas++;
		$Y_pos = $Y_pos + 6;
	
	}
	$pdf->Output();
	
	
	
?>