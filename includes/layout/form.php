<form>
    <div class="form">
        <div class="field">
            <label for="category">Categoria:</label>
            <select name="category" class="field-input" id="category">
                <option value="1" selected>Pago de nomina</option>
                <option value="2" >Inversiones</option>
                <option value="3">Ventas</option>
                <option value="4">Otros</option>
            </select>
        </div>
        <div class="field">
            <label for="amount">Monto:</label>
            <input type="number"  name="amount" id="amount" class="field-input">
        </div>
        <div class="field">
            <label for="date">Fecha:</label>
            <input type="datetime-local" name="date" id="date" class="field-input">
        </div>
        <div class="field">
            <button class="btn-primary" id="submitButton" >Agregar</button>
        </div>
    </div>
</form>