const btnPickUp = document.getElementById('btn-pickup');
const btnDelivery = document.getElementById('btn-delivery');
const tmpl = document.getElementById('tmpl');
const pickupTemplate = `
      <div class="row">
        <div class="col billing-fields">
          <h3 class="h4">Détails de facturation</h3>
          <div>
            <div>
              <label>
                <span>Prenom</span>
                <input type="text" />
              </label>
              <label>
                <span>Nom</span>
                <input type="text" />
              </label>
            </div>
            <div>
              <label>
                <span>Telephone</span>
                <input type="tel" name="tel" />
              </label>
            </div>
            <div>
              <label>
                <span>Adresse mail</span>
                <input type="email" name="email" />
              </label>
            </div>
          </div>
        </div>

        <div class="col hour-delivery">
          <h3>Horaire de retrait</h3>
          <div>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 11h30 a 12h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 12h a 12h30</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 12h30 a 13h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 13h a 13h30</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 13h30 a 14h</span>
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="hour_delivery" />
                <span>de 14h a 14h30</span>
              </label>
            </p>
          </div>
        </div>
      </div>
    `;
const deliveryTemplate = `<div>delivery template</div>`;
tmpl.innerHTML = pickupTemplate;
btnPickUp.addEventListener('click', evt => {
  evt.preventDefault()
  tmpl.innerHTML = pickupTemplate;
});
btnDelivery.addEventListener('click', evt => {
  evt.preventDefault()
  tmpl.innerHTML = deliveryTemplate;
})

