<table>
	<thead>
		<tr>
			<th width="16%">Tanggal &amp; Jam</th>
			<th width="14%">Mall &amp; Kota</th>
			<th width="14%">Nama</th>
			<th width="14%">No. Telepon</th>
			<th width="14%">Email</th>
			<th width="14%">Provider</th>
			<th width="14%">Hadiah</th>
		</tr>
	</thead>
	<tbody>
		<?php
        if (count($dataParticipant['myCode']) > 0) {
            foreach ($dataParticipant['myCode'] as $val) {
        ?>
                <tr>
                    <td><?php echo $val['datetime'] ?></td>
                    <td><?php echo $val['mall'] ?></td>
                    <td><?php echo $val['name'] ?></td>
                    <td><?php echo $val['phone'] ?></td>
                    <td><?php echo $val['email'] ?></td>
                    <td><?php echo $val['provider'] ?></td>
                    <td><?php echo $val['prize'] ?></td>
                </tr>
        <?php
            }
        } else {
        ?>
            <tr>
				<td colspan="7">Data Kosong</td>
			</tr>
        <?php
        }
        ?>
	</tbody>
</table>

<div class="pagination">
	<?php echo $dataParticipant['page_links']; ?>
</div>