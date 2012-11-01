<?php
/**
 * A view script for showing the email notification sent to library
 * staff when a user submits a request.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-scripts
 * @see ForbesPurchaseForm_RequestController
 */
 
$items = $request->getItems();
?>
<h2>Request for Image Reproductions or Permission to Publish</h2>
<p>For <?php echo $request->name; ?>, Received on <?php echo date('d M Y'); ?></p>

<h3>Contact Information</h3>
<table>
<tr><th>Name</th><td><?php echo $request->name; ?></td></tr>
<tr><th>Email</th><td><?php echo $request->email; ?></td></tr>
<tr><th>Phone</th><td><?php echo $request->phone; ?></td></tr>
<tr><th>Address</th><td><?php echo $this->mailingAddress($request->address); ?></td></tr>
</table>

<h3>Request Materials</h3>
<table>
<tr><th>Identifier</th><th>Title</th><th>Link</th></tr>
<?php
foreach ($items as $item) {
    set_current_item($item);
    $identifier =  item('Dublin Core', 'Identifier');
    $title =  item('Dublin Core', 'Title');
    $link =  link_to_item(__('view'));
    echo "<tr><td>$identifier</td><td>$title</td><td>($link)</td></tr>";
} ?>
</table>

<?php
foreach ($request as $key => $value) {
    if (isset($value)) {
        $value = print_r($value, True);
        echo "<p>$key: $value</p>";
    }
} ?>
