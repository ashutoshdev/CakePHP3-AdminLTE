<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Asso Category'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="assoCategories index large-9 medium-8 columns content">
    <h3><?= __('Asso Categories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assoCategories as $assoCategory): ?>
            <tr>
                <td><?= $this->Number->format($assoCategory->id) ?></td>
                <td><?= h($assoCategory->name) ?></td>
                <td><?= h($assoCategory->created) ?></td>
                <td><?= h($assoCategory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $assoCategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assoCategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assoCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assoCategory->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
