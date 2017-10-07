<table class="table table-striped table-hover">
    <thead>
        <tr><th>Date</th><th>Category</th><th>Client</th><th>Label</th><th>Value</th></tr>
    </thead>
    <tbody>
    <?php 
        $total = 0;
        foreach($stats as $row) { 
        $total += $row->value;
        ?>
        <tr><td>{{ $row->date }}</td><td>{{ $row->category_id }}</td><td>{{ $row->client_id }}</td><td>{{ $row->label_id }}</td><td>{{ $row->value }}</td></tr>
    <?php } ?>
        <tr><td><strong>Total</strong></td><td></td><td></td><td></td><td><strong>{{ $total }}</strong></td></tr>
    </tbody>
</table>