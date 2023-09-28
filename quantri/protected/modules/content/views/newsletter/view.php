<table class="table table-bordered table-hover vertical-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created Time</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $model['id'] ?></td>
            <td><?php echo $model['name'] ?></td>
            <td><?php echo $model['email'] ?></td>
            <td><?php echo $model['phone'] ?></td>
            <td><?php echo date('m-d-Y', $model['created_time']) ?></td>
        </tr>
    </tbody>
</table>
