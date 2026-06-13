document.addEventListener('DOMContentLoaded', () => {
    const cepInput = document.getElementById('cep');
    const status = document.getElementById('cep-status');
    const endereco = document.getElementById('endereco');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const uf = document.getElementById('uf');
    const deliveryFields = document.getElementById('delivery-fields');
    const pickupNote = document.getElementById('pickup-note');
    const deliveryRequiredFields = document.querySelectorAll('[data-delivery-field]');
    const fulfillmentInputs = document.querySelectorAll('input[name="forma_retirada"]');
    const summaryFrete = document.getElementById('summary-frete');
    const summaryTotalPix = document.getElementById('summary-total-pix');
    const summaryCard = document.getElementById('summary-card');

    const updateFulfillment = () => {
        const selected = document.querySelector('input[name="forma_retirada"]:checked')?.value || 'entrega';
        const isDelivery = selected === 'entrega';

        if (deliveryFields) deliveryFields.hidden = !isDelivery;
        if (pickupNote) pickupNote.hidden = isDelivery;

        deliveryRequiredFields.forEach((field) => {
            field.required = isDelivery;
        });

        if (summaryFrete) summaryFrete.textContent = summaryFrete.dataset[selected] || summaryFrete.textContent;
        if (summaryTotalPix) summaryTotalPix.textContent = summaryTotalPix.dataset[selected] || summaryTotalPix.textContent;
        if (summaryCard) summaryCard.textContent = summaryCard.dataset[selected] || summaryCard.textContent;
    };

    fulfillmentInputs.forEach((input) => input.addEventListener('change', updateFulfillment));
    updateFulfillment();

    if (!cepInput || !status || !endereco || !bairro || !cidade || !uf) return;

    const setStatus = (message, type = '') => {
        status.textContent = message;
        status.classList.remove('field-hint--error', 'field-hint--ok');
        if (type) status.classList.add(`field-hint--${type}`);
    };

    const formatCep = (value) => {
        const digits = value.replace(/\D/g, '').slice(0, 8);
        if (digits.length > 5) {
            return `${digits.slice(0, 5)}-${digits.slice(5)}`;
        }
        return digits;
    };

    cepInput.addEventListener('input', () => {
        cepInput.value = formatCep(cepInput.value);
    });

    cepInput.addEventListener('blur', async () => {
        const cep = cepInput.value.replace(/\D/g, '');

        if (!cep) {
            setStatus('Digite o CEP para buscar o endereço.');
            return;
        }

        if (cep.length !== 8) {
            setStatus('CEP inválido. Informe 8 dígitos.', 'error');
            return;
        }

        setStatus('Buscando endereço...');

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            if (!response.ok) throw new Error('Falha na consulta');

            const data = await response.json();
            if (data.erro) {
                setStatus('CEP não encontrado.', 'error');
                return;
            }

            endereco.value = data.logradouro || '';
            bairro.value = data.bairro || '';
            cidade.value = data.localidade || '';
            uf.value = data.uf || '';
            setStatus('Endereço encontrado pelo CEP.', 'ok');
        } catch (error) {
            setStatus('Não foi possível consultar o CEP agora.', 'error');
        }
    });
});
