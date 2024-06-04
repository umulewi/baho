<div class="form-row">
    <div>
        <label for="id">ID</label>
        <input type="text" id="id" name="id" maxlength="16" pattern="[0-9]{16}" title="Please enter a 16-digit ID number." required>
    </div>
</div>
<script>
const idInput = document.getElementById("id");

idInput.addEventListener("input", function() {
  const value = idInput.value;
  if (value.length > 16) {
    idInput.value = value.slice(0, 16); 
  }
  
});
</script>
