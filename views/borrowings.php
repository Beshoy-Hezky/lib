<h1>Borrowing Records</h1>
<table>
    <tr><th>Book</th><th>User</th><th>Borrowed</th><th>Returned</th></tr>
    <?php foreach ($records as $r): ?>
    <tr>
        <td><?php echo htmlspecialchars($r['title']); ?></td>
        <td><?php echo htmlspecialchars($r['email']); ?></td>
        <td><?php echo htmlspecialchars($r['borrow_date']); ?></td>
        <td><?php echo $r['return_date'] ? htmlspecialchars($r['return_date']) : 'Not returned'; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
