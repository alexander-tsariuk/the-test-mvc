<div id="comments-body">
    <?php
    if(isset($items) && !empty($items)):
        foreach ($items as $item): ?>
            <div class="comment-item">
                <hr>
                <div class="comment-meta">
                    <span id="comment-meta-name"><?= $item->name ;?></span>
                    <span id="comment-meta-email"><?= $item->email ;?></span>
                    <span id="comment-meta-timestamp"><?= $item->created_at ;?></span>
                </div>
                <div class="comment-title">
                    <?= $item->title ;?>
                </div>
                <div class="comment-text">
                    <?= $item->comment ;?>
                </div>
            </div>
        <?php endforeach;
    endif;?>
</div>

<?php if($items->lastPage() > 1):?>
    <div id="comments-pagination">
        <a  href="#"
            id="prev"
            data-page="<?= $items->currentPage() > 1 ? $items->currentPage() - 1 : 1?>"
            <?= ($items->lastPage() == 1 || $items->currentPage() == 1) ? 'class="disabled"' : ''  ;?>
        >&laquo;</a>

        <?php for ($i = 1; $i <= $items->lastPage(); $i++):?>
            <a href="#" data-page="<?= $i;?>" <?= $items->currentPage() == $i ? 'id="current"' : '';?>><?= $i;?></a>
        <?php endfor;?>

        <a  href="#"
            id="next"
            data-page="<?= $items->total() > $items->currentPage() ? $items->currentPage() + 1 : ''?>"
            <?= (($items->lastPage() == $items->currentPage())) ? 'class="disabled"' : ''  ;?>
        >&raquo;</a>
    </div>
<?php endif;?>