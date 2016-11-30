<table id="received_quotes" class="table table-bordered">
    <thead>
    <tr>
        <th>ID#</th>
        <th>Amount</th>
        <th>Maintenance</th>
        <th>Bid Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $pending_quotes = $quotes->selectQuery('contractors_quotations','*')
    ?>
    <tr>

    </tr>
    </tbody>
</table>
<div class="clearfix"></div>
