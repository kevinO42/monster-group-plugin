<?php 
    global $wpdb;
    $table = $wpdb->prefix . 'mg_leads';
    $results = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
?>
<div class="wrap">
    <h1>Leads</h1>

    <div class="table-wrapper">
        <table class="widefat fixed fl-table">
            <thead>
                <tr>
                    <th>Name</th> 
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Service Required</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                    <th>Name</th> 
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Service Required</th>
                    <th>Date Submitted</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results as $res): 
                    $name = $res->name;
                    $email = $res->email;
                    $phone_number = $res->phone_number;
                    $service = $res->service;
                    $submitted_at = $res->created_at;
                ?>
                <tr>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $phone_number; ?></td>
                    <td><?php echo $service; ?></td>
                    <td><?php echo $submitted_at; ?></td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($results)): ?>
                <tr>
                    <td colspan="5">No customer leads as of the moment.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>