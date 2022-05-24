<style type="text/css">
	html {
		font-family: Calibri, Arial, Helvetica, sans-serif;
		font-size: 11pt;
		background-color: white
	}

	a.comment-indicator:hover+div.comment {
		background: #ffd;
		position: absolute;
		display: block;
		border: 1px solid black;
		padding: 0.5em
	}

	a.comment-indicator {
		background: red;
		display: inline-block;
		border: 1px solid black;
		width: 0.5em;
		height: 0.5em
	}

	div.comment {
		display: none
	}

	table {
		border-collapse: collapse
	}

	.b {
		text-align: center
	}

	.e {
		text-align: center
	}

	.f {
		text-align: right
	}

	.inlineStr {
		text-align: left
	}

	.n {
		text-align: right
	}

	.s {
		text-align: left
	}

	td.style0 {
		vertical-align: bottom;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style0 {
		vertical-align: bottom;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style1 {
		vertical-align: bottom;
		text-align: center;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style1 {
		vertical-align: bottom;
		text-align: center;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style2 {
		vertical-align: middle;
		text-align: center;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style2 {
		vertical-align: middle;
		text-align: center;
		border-bottom: none #000000;
		border-top: none #000000;
		border-left: none #000000;
		border-right: none #000000;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style3 {
		vertical-align: middle;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style3 {
		vertical-align: middle;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style4 {
		vertical-align: bottom;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style4 {
		vertical-align: bottom;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style5 {
		vertical-align: bottom;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style5 {
		vertical-align: bottom;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	td.style6 {
		vertical-align: middle;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		font-weight: bold;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	th.style6 {
		vertical-align: middle;
		text-align: center;
		border-bottom: 1px solid #000000 !important;
		border-top: 1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		border-right: 1px solid #000000 !important;
		font-weight: bold;
		color: #000000;
		font-family: 'Calibri';
		font-size: 11pt;
		background-color: white
	}

	table.sheet0 col.col0 {
		width: 18pt
	}

	table.sheet0 col.col1 {
		width: 55.5pt
	}

	table.sheet0 col.col2 {
		width: 86.25pt
	}

	table.sheet0 col.col3 {
		width: 111pt
	}

	table.sheet0 col.col4 {
		width: 105pt
	}

	table.sheet0 col.col5 {
		width: 117pt
	}

	table.sheet0 col.col6 {
		width: 67.5pt
	}

	table.sheet0 col.col7 {
		width: 160.5pt
	}

	table.sheet0 tr {
		height: 15pt
	}

	@page page0 {
		margin-left: 0.7in;
		margin-right: 0.7in;
		margin-top: 0.75in;
		margin-bottom: 0.75in;
	}

	.navigation {
		page-break-after: always;
	}

	div+div {}

	@media screen {
		.gridlines td {
			border: 1px solid black;
		}

		.gridlines th {
			border: 1px solid black;
		}

		body>div {
			margin-top: 5px;
		}

		body>div:first-child {
			margin-top: 0;
		}

		.scrpgbrk {
			margin-top: 1px;
		}
	}

	@media print {
		.gridlinesp td {
			border: 1px solid black;
		}

		.gridlinesp th {
			border: 1px solid black;
		}

		.navigation {
			display: none;
		}
	}

    .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
</style>
<div style='page: page0;align-content: center;display: flex;flex-direction: column;'>
	<table border='0' cellpadding='0' cellspacing='0' id='sheet0' class='sheet0 gridlines'>
		<col class="col0" />
		<col class="col1" />
		<col class="col2" />
		<col class="col3" />
		<col class="col4" />
		<col class="col5" />
		<col class="col6" />
		<col class="col7" />
		<tbody>
			<tr class="row0">
				<td class="column0 style6 s">No</td>
				<td class="column1 style6 s">No Surat</td>
				<td class="column2 style6 s">Tanggal Surat</td>
				<td class="column3 style6 s">Tanggal Penomoran</td>
				<td class="column4 style6 s">Perihal</td>
				<td class="column5 style6 s">User Create Bidang</td>
				<td class="column6 style6 s">Tipe</td>
				<td class="column7 style6 s">Unit Kerja</td>
			</tr>
            @foreach ($penomoran as $key => $value)
                <tr class="">
                    <td class="column0 style4 n">{{$value['nomor']}}</td>
                    <td class="column1 style5 n"style="text-align: center;">{{$value['no_surat']}}</td>
                    <td class="column2 style5 s">{{$value['tanggal']}}</td>
                    <td class="column3 style5 s">{{$value['date_number']}}</td>
                    <td class="column4 style5 s">{{$value['regarding']}}</td>
                    <td class="column5 style5 s">{{$value['pengirim']}}</td>
                    <td class="column6 style5 s">{{$value['tipe']}}</td>
                    <td class="column7 style5 s">{{$value['unit_kerja']}}</td>
                </tr>
            @endforeach
		</tbody>
	</table>
</div>
