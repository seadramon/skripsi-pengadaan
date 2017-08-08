<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Laporan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function permintaan($start, $end, $status = "")
	{
		if ($status!="") $this->db->where('status', $status);
		$this->db->where('tanggal >=', $start);
		$this->db->where('tanggal <=', $end);

		return $this->db->get('permintaan')->result_array();
	}

	function permintaanPdf($start = "", $end = "", $status = "")
	{
		if ($status!="") $this->db->where('permintaan.status', $status);
		if ($start!="") $this->db->where('permintaan.tanggal >=', $start);
		if ($end!="") $this->db->where('permintaan.tanggal <=', $end);

		$this->db->select('permintaan.nik, permintaan.idminta, barang.nama, detail_permintaan.jumlah, detail_permintaan.keterangan, 
			detail_permintaan.tanggal_pengiriman, permintaan.tanggal_disetujui, karyawan.nama as gbb, detail_permintaan.status');
		$this->db->from('permintaan');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_permintaan.idbarang = barang.idbarang', 'left');
		$this->db->join('karyawan', 'permintaan.nik = karyawan.nik', 'left');
		
		return $this->db->get()->result_array();
	}

	function rekappermintaan($start, $end)
	{
		$this->db->where('permintaan.tanggal >=', $start);
		$this->db->where('permintaan.tanggal <=', $end);

		$this->db->select('permintaan.idminta, barang.nama, detail_permintaan.jumlah, detail_permintaan.tanggal_pengiriman,
			detail_permintaan.keterangan, permintaan.status');
		$this->db->from('permintaan');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_permintaan.idbarang = barang.idbarang', 'left');

		return $this->db->get()->result_array();
	}

	function rekappermintaanPdf($start = "", $end = "")
	{
		$this->db->where('permintaan.tanggal >=', $start);
		$this->db->where('permintaan.tanggal <=', $end);

		$this->db->select('permintaan.idminta, barang.nama, detail_permintaan.jumlah, detail_permintaan.tanggal_pengiriman,
			detail_permintaan.keterangan, permintaan.status');
		$this->db->from('permintaan');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_permintaan.idbarang = barang.idbarang', 'left');

		return $this->db->get()->result_array();
	}

	function jmlrekapPermintaan($start, $end)
	{
		$ret = 0;

		$this->db->where('permintaan.tanggal >=', $start);
		$this->db->where('permintaan.tanggal <=', $end);

		$this->db->select('COUNT(idminta) as jml');
		$this->db->from('permintaan');
		$query = $this->db->get()->row_array();

		$ret = $query['jml'];
		return $ret;
	}

	function jmlKonfirmasiRekap($start, $end, $status = "")
	{
		$ret = 0;

		$this->db->where('permintaan.tanggal >=', $start);
		$this->db->where('permintaan.tanggal <=', $end);
		$this->db->where('permintaan.status', $status);

		$this->db->select('COUNT(idminta) as jml');
		$this->db->from('permintaan');
		$query = $this->db->get()->row_array();

		$ret = $query['jml'];
		return $ret;
	}

	function jmlStatusRekap($start, $end, $status = "")
	{
		$ret = 0;

		$this->db->where('permintaan.tanggal >=', $start);
		$this->db->where('permintaan.tanggal <=', $end);
		$this->db->where('detail_permintaan.status', $status);

		$this->db->select('COUNT(detail_permintaan.idbarang) as jml');
		$this->db->from('permintaan');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_permintaan.idbarang = barang.idbarang', 'left');
		$query = $this->db->get()->row_array();

		$ret = $query['jml'];
		return $ret;
	}

	function po($start, $end)
	{
		$this->db->where('po.tanggal >=', $start);
		$this->db->where('po.tanggal <=', $end);

		$this->db->select('po.idpo, barang.nama as barang, detail_order.tanggal_pengiriman, detail_order.jumlah, 
			detail_order.harga_satuan, detail_order.jumlah_harga');
		$this->db->from('po');
		$this->db->join('detail_order', 'po.idpo = detail_order.idpo', 'left');
		$this->db->join('barang', 'detail_order.idbarang = barang.idbarang', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	function poHead($start, $end)
	{
		$this->db->where('po.tanggal >=', $start);
		$this->db->where('po.tanggal <=', $end);

		$this->db->select('idpo, total');
		$this->db->from('po');

		$query = $this->db->get();
		return $query->result_array();
	}

	function poPdf($start, $end)
	{
		$this->db->where('po.tanggal >=', $start);
		$this->db->where('po.tanggal <=', $end);

		$this->db->select('po.idpo, detail_order.idpo as idpoDetail, barang.nama as barang, barang.idbarang, detail_order.tanggal_pengiriman, 
			detail_order.jumlah, detail_order.harga_satuan, detail_order.jumlah_harga, supplier.nama as supplier, po.tanggal, po.total');
		$this->db->from('po');
		$this->db->join('detail_order', 'po.idpo = detail_order.idpo', 'left');
		$this->db->join('barang', 'detail_order.idbarang = barang.idbarang', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		// dd($query->result_array());
		return $query->result_array();
	}

	function penerimaan($start, $end)
	{
		$this->db->where('penerimaan.tanggal >=', $start);
		$this->db->where('penerimaan.tanggal <=', $end);

		$this->db->select('penerimaan.idpenerimaan, penerimaan.idpo, barang.nama as barang, penerimaan.tanggal');
		$this->db->from('penerimaan');
		$this->db->join('detail_penerimaan', 'penerimaan.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');
		$this->db->join('barang', 'detail_penerimaan.idbarang = barang.idbarang', 'left');

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	function penerimaanPdf($start, $end)
	{
		$this->db->where('penerimaan.tanggal >=', $start);
		$this->db->where('penerimaan.tanggal <=', $end);

		$this->db->select('penerimaan.idpenerimaan, penerimaan.idpo, supplier.nama as supplier, barang.nama as barang, 
			penerimaan.tanggal, detail_penerimaan.jumlah as jmlTerima,  
			(select jumlah from detail_order where idpo = penerimaan.idpo and idbarang = detail_penerimaan.idbarang) as jmlPesan');
		$this->db->from('penerimaan');
		$this->db->join('detail_penerimaan', 'penerimaan.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');
		$this->db->join('po', 'penerimaan.idpo = po.idpo', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
		$this->db->join('barang', 'detail_penerimaan.idbarang = barang.idbarang', 'left');

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	function perintahbayar($start, $end, $status = "")
	{
		if ($status!="") $this->db->where('pembayaran.status', $status);
		$this->db->where('pembayaran.tanggal_perintahbayar >=', $start);
		$this->db->where('pembayaran.tanggal_perintahbayar <=', $end);

		$this->db->select('pembayaran.idpembayaran, pembayaran.idpo, supplier.nama as supplier, pembayaran.tanggal_perintahbayar,
			pembayaran.status');
		$this->db->from('pembayaran');
		$this->db->join('po', 'pembayaran.idpo = po.idpo', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	function perintahbayarPdf($start, $end, $status)
	{
		if ($status!="") $this->db->where('pembayaran.status', $status);
		$this->db->where('pembayaran.tanggal_perintahbayar >=', $start);
		$this->db->where('pembayaran.tanggal_perintahbayar <=', $end);

		$this->db->select('pembayaran.idpembayaran, pembayaran.idpo, supplier.nama as supplier, pembayaran.tanggal_perintahbayar,
			pembayaran.status, pembayaran.jml_bayar, po.total');
		$this->db->from('pembayaran');
		$this->db->join('po', 'pembayaran.idpo = po.idpo', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	function pembayaran($start, $end, $status = "")
	{
		if ($status!="") $this->db->where('pembayaran.status', $status);
		$this->db->where('pembayaran.tanggal_perintahbayar >=', $start);
		$this->db->where('pembayaran.tanggal_perintahbayar <=', $end);

		$this->db->select('pembayaran.idpembayaran, pembayaran.idpo, supplier.nama as supplier, pembayaran.tanggal_perintahbayar,
			pembayaran.status, pembayaran.jml_bayar, po.total');
		$this->db->from('pembayaran');
		$this->db->join('po', 'pembayaran.idpo = po.idpo', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	function pembayaranHead($start, $end, $status = "")
	{
		if ($status!="") $this->db->where('pembayaran.status', $status);
		$this->db->where('pembayaran.tanggal_perintahbayar >=', $start);
		$this->db->where('pembayaran.tanggal_perintahbayar <=', $end);

		$this->db->select('pembayaran.idpembayaran, pembayaran.idpo, pembayaran.status, pembayaran.jml_bayar, po.total, pembayaran.tanggal_dibayar');
		$this->db->from('pembayaran');
		$this->db->join('po', 'pembayaran.idpo = po.idpo', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	function pembayaranPdf($start, $end, $status = "")
	{
		if ($status!="") $this->db->where('pembayaran.status', $status);
		$this->db->where('pembayaran.tanggal_perintahbayar >=', $start);
		$this->db->where('pembayaran.tanggal_perintahbayar <=', $end);

		$this->db->select('pembayaran.idpembayaran, pembayaran.idpo, supplier.nama as supplier, pembayaran.tanggal_perintahbayar,
			pembayaran.status, pembayaran.jml_bayar, po.total, detail_order.jumlah, detail_order.harga_satuan, detail_order.jumlah_harga');
		$this->db->from('pembayaran');
		$this->db->join('po', 'pembayaran.idpo = po.idpo', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
		$this->db->join('detail_order', 'po.idpo = detail_order.idpo', 'left');
		$this->db->join('barang', 'detail_order.idbarang = barang.idbarang', 'left');
		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	function barangmasuk($start, $end, $status = "")
	{
		$this->db->where('penerimaan.tanggal >=', $start);
		$this->db->where('penerimaan.tanggal <=', $end);

		$this->db->where('detail_permintaan.status', 'arrived');
		$this->db->select("penerimaan.idpenerimaan, penerimaan.tanggal, barang.nama as barang, detail_penerimaan.jumlah, 
			detail_permintaan.status");
		$this->db->from('penerimaan');
		$this->db->join('detail_penerimaan', 'penerimaan.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');
		$this->db->join('po', 'penerimaan.idpo = po.idpo');
		$this->db->join('permintaan', 'po.idminta = permintaan.idminta');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_penerimaan.idbarang = barang.idbarang', 'left');
		$this->db->group_by(["penerimaan.idpenerimaan", "detail_penerimaan.idbarang"]);

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();	
	}

	function barangmasukPdf($start, $end) {
		$this->db->where('penerimaan.tanggal >=', $start);
		$this->db->where('penerimaan.tanggal <=', $end);

		$this->db->where('detail_permintaan.status', 'arrived');
		$this->db->select("penerimaan.idpenerimaan, penerimaan.tanggal, barang.nama as barang, detail_penerimaan.jumlah, 
			detail_permintaan.status");
		$this->db->from('penerimaan');
		$this->db->join('detail_penerimaan', 'penerimaan.idpenerimaan = detail_penerimaan.idpenerimaan', 'left');
		$this->db->join('po', 'penerimaan.idpo = po.idpo');
		$this->db->join('permintaan', 'po.idminta = permintaan.idminta');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_penerimaan.idbarang = barang.idbarang', 'left');
		$this->db->group_by(["penerimaan.idpenerimaan", "detail_penerimaan.idbarang"]);

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	function barangkeluar($start, $end)
	{
		$this->db->where('barangkeluar.tanggal >=', $start);
		$this->db->where('barangkeluar.tanggal <=', $end);

		$this->db->where('detail_permintaan.status', 'used');
		$this->db->select("barangkeluar.idbarangkeluar, barangkeluar.idminta, barangkeluar.tanggal, barang.nama as barang,
			detail_barangkeluar.jumlah, detail_permintaan.keterangan");
		$this->db->from('barangkeluar');
		$this->db->join('detail_barangkeluar', 'barangkeluar.idbarangkeluar = detail_barangkeluar.idbarangkeluar');
		$this->db->join('permintaan', 'barangkeluar.idminta = permintaan.idminta');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_barangkeluar.idbarang = barang.idbarang', 'left');
		$this->db->group_by(["barangkeluar.idbarangkeluar", "detail_barangkeluar.idbarang"]);

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();	
	}

	function barangkeluarPdf($start, $end)
	{
		$this->db->where('barangkeluar.tanggal >=', $start);
		$this->db->where('barangkeluar.tanggal <=', $end);

		$this->db->where('detail_permintaan.status', 'used');
		$this->db->select("barangkeluar.idbarangkeluar, barangkeluar.idminta, barangkeluar.tanggal, barang.nama as barang,
			detail_barangkeluar.jumlah, detail_permintaan.keterangan");
		$this->db->from('barangkeluar');
		$this->db->join('detail_barangkeluar', 'barangkeluar.idbarangkeluar = detail_barangkeluar.idbarangkeluar');
		$this->db->join('permintaan', 'barangkeluar.idminta = permintaan.idminta');
		$this->db->join('detail_permintaan', 'permintaan.idminta = detail_permintaan.idminta', 'left');
		$this->db->join('barang', 'detail_barangkeluar.idbarang = barang.idbarang', 'left');
		$this->db->group_by(["barangkeluar.idbarangkeluar", "detail_barangkeluar.idbarang"]);

		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		return $query->result_array();	
	}

	/*MKI*/
	function testHead($start, $end)
	{
		$this->db->where('po.tanggal >=', $start);
		$this->db->where('po.tanggal <=', $end);

		$this->db->select('po.idpo, po.total, po.tanggal, supplier.nama as supplier');
		$this->db->from('po');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
		// $this->db->isdebug(TRUE);

		$query = $this->db->get();
		return $query->result_array();
	}

	function testPdf($start, $end)
	{
		$this->db->where('po.tanggal >=', $start);
		$this->db->where('po.tanggal <=', $end);

		$this->db->select('po.idpo, detail_order.idpo as idpoDetail, barang.nama as barang, barang.idbarang, detail_order.tanggal_pengiriman, 
			detail_order.jumlah, detail_order.harga_satuan, detail_order.jumlah_harga, supplier.nama as supplier, po.tanggal, po.total');
		$this->db->from('po');
		$this->db->join('detail_order', 'po.idpo = detail_order.idpo', 'left');
		$this->db->join('barang', 'detail_order.idbarang = barang.idbarang', 'left');
		$this->db->join('supplier', 'po.idsupplier = supplier.idsupplier', 'left');
		// $this->db->isdebug(TRUE);
		$query = $this->db->get();
		// dd($query->result_array());
		return $query->result_array();
	}
}