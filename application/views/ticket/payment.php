<?php echo form_open('ticket/update'); ?>
<?php 	
$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
?>
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
  <th>QTY</th>
  <th>Tournament</th>
  <th>Ticket Type</th>
  <th>Date</th>
  <th style="text-align:right">Item Price</th>
  <th style="text-align:right">Sub-Total</th>
</tr>

<?php $i = 1; ?>
<?php echo form_hidden('postdata', $postdata); ?>
<?php foreach ($this->cart->contents() as $items): ?>

	<?php echo form_hidden($i.'rowid', $items['rowid']); ?>
	<tr>
	  <td><?php echo form_input(array('name' => $i.'qty', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '3')); ?></td>	  
	  <td><?php echo $items['tName']; ?></td>
	  <td><?php echo $items['name']; ?></td>
	  <td><?php echo $items['date']; ?></td>
	  <td style="text-align:right">£<?php echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right">£<?php echo $this->cart->format_number($items['subtotal']); ?></td>
	</tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
  <td colspan="2"> </td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">£<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>

<?php echo form_submit('submit', 'Update your Cart'); ?>
<?= form_close(); ?>
</br>

<h2>Customer Infomation</h2>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">     
  <tbody>

    <tr><td><b>First Name</b></td><td><?php echo $postdata['firstName'] ?></td></tr>
    <tr><td><b>Surname</b></td><td><?php echo $postdata['surName'] ?></td></tr>
    <tr><td><b>Address 1</b></td><td><?php echo $postdata['addr1'] ?></td></tr>
    <tr><td><b>Address 2</b></td><td><?php echo $postdata['addr2'] ?></td></tr>
    <tr><td><b>Postcode</b></td><td><?php echo $postdata['postcode'] ?></td></tr>
    <tr><td><b>City</b></td><td><?php echo $postdata['city'] ?></td></tr>
    <tr><td><b>Email</b></td><td><?php echo $postdata['email'] ?></td></tr>
  </tbody>
</table>
<?php echo form_open('ticket/confirm'); ?>
<?php 	
if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	} 
?>
<?php echo form_hidden('postdata', $postdata); ?>
<?php echo form_submit('submit', 'Confirm Order'); ?>
<?= form_close(); ?>
