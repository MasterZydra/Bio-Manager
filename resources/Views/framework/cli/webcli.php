<div>

    <div>
        <textarea id="responses" readonly style="width: 100%; height: 80%; overflow: auto;"></textarea>
    </div>
    
    <form id="form" action="" method="post" style="display: flex;">
        <label for="command" class="required"><?= __('Command') ?>:</label><br>
        <input id="command" name="command" type="text" required autofocus><br>
        <button onclick="sendCommand(event)"><?= __('Send') ?></button>
    </form>
</div>

<script>

async function sendCommand(event)
{
    let command = document.getElementById("command").value;
    event.preventDefault();

    let response = await fetch(
        window.location.href,
        {
            method: "POST",
            body: new FormData(document.getElementById("form"))
        }
    );
    let responsetext = await response.text();
    document.getElementById("responses").value += responsetext;
    document.getElementById("responses").value += '----------------------------------------------\n'; 
}

</script>