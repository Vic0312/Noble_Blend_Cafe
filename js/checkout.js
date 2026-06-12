document.addEventListener('DOMContentLoaded', () => {
    const cepInput = document.getElementById('cep');
    const status = document.getElementById('cep-status');
    const endereco = document.getElementById('endereco');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const uf = document.getElementById('uf');

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
