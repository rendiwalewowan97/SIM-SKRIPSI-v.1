<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-3xl rounded bg-white shadow">
    <div class="border-b p-4"><h1 class="text-xl font-bold">Chat dengan <?php echo e($receiver->name); ?></h1><p class="text-sm text-slate-500"><?php echo e(ucfirst($receiver->role)); ?></p></div>
    <div id="messages" class="h-[500px] space-y-3 overflow-y-auto bg-slate-50 p-4"></div>
    <form id="chatForm" class="flex gap-2 border-t p-4"><?php echo csrf_field(); ?>
        <input id="messageInput" type="text" name="message" class="w-full rounded border p-2" placeholder="Tulis pesan..." required>
        <button class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Kirim</button>
    </form>
</div>
<script>
const box = document.getElementById('messages');
const form = document.getElementById('chatForm');
const input = document.getElementById('messageInput');
function render(messages){
    box.innerHTML = messages.length ? '' : '<p class="text-center text-slate-500">Belum ada pesan.</p>';
    messages.forEach(m => {
        box.insertAdjacentHTML('beforeend', `<div class="flex ${m.mine ? 'justify-end' : 'justify-start'}"><div class="max-w-xs rounded-lg px-4 py-2 ${m.mine ? 'bg-indigo-600 text-white' : 'bg-white shadow'}"><p>${m.message}</p><small class="block text-right text-xs ${m.mine ? 'text-indigo-100' : 'text-slate-400'}">${m.time}</small></div></div>`);
    });
    box.scrollTop = box.scrollHeight;
}
async function loadMessages(){ const r = await fetch(`<?php echo e(route('chats.fetch',$receiver)); ?>`); render(await r.json()); }
form.addEventListener('submit', async e => {
    e.preventDefault();
    const text = input.value.trim(); if (!text) return;
    input.value = '';
    await fetch(`<?php echo e(route('chats.store',$receiver)); ?>`, {method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Accept':'application/json','Content-Type':'application/json'}, body:JSON.stringify({message:text})});
    loadMessages();
});
loadMessages(); setInterval(loadMessages, 2000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/chats/show.blade.php ENDPATH**/ ?>