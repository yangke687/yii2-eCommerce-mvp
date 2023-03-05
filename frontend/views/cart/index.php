<?php


/* @var $this \yii\web\View */
/* @var $items array */

?>


<h3>
    Your cart items
</h3>

<br/>

<?php if (!empty($items)): ?>
<table class="table table-hover">
    <thead>
    <th>Product</th>
    <th>Unit Price</th>
    <th>Quantity</th>
    <th>Total Price</th>
    <th>Action</th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td style="display: flex;">
                <?php
                $imageUrl = \common\models\Product::formatImageUrl($item['image']);
                echo \yii\helpers\Html::img(
                    $imageUrl,
                    ['width' => 50, 'style' => 'margin-right: 10px;']
                );
                echo $item['name'];
                ?>
            </td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['quantity']; ?></td>
            <td><?= $item['total_price'] ?></td>
            <td>
                <?= \yii\helpers\Html::a(
                    'Delete',
                    ['/cart/delete', 'id' => $item['id']],
                    [
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data-method' => 'post',
                        'data-confirm' => 'Are you sure to remove this item from cart?',
                    ]
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="text-right">
    <?= \yii\helpers\Html::a('Checkout', ['/cart/checkout'], ['class' => 'btn btn-primary']) ?>
</div>

<?php else: ?>
<p class="text-muted text-center p-5">There are no goods</p>
<?php endif; ?>



