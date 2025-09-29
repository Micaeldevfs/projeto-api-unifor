document.addEventListener("DOMContentLoaded", function () {
  const buscarBtn = document.getElementById("buscar-btn");
  const cepInput = document.getElementById("cep-input");
  const salvarBtn = document.getElementById("salvar-btn");
  const resultadoBuscaDiv = document.getElementById("resultado-busca");
  const enderecosSalvosDiv = document.getElementById("enderecos-salvos");

  let enderecoAtual = {};

  async function buscarCep() {
    const cep = cepInput.value.replace(/\D/g, "");
    if (cep.length !== 8) {
      alert("CEP inválido. Por favor, digite 8 números.");
      return;
    }
    try {
      const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      const data = await response.json();
      if (data.erro) {
        alert("CEP não encontrado.");
        resultadoBuscaDiv.style.display = "none";
      } else {
        document.getElementById("res-cep").textContent = data.cep;
        document.getElementById("res-logradouro").textContent = data.logradouro;
        document.getElementById("res-bairro").textContent = data.bairro;
        document.getElementById(
          "res-cidade-uf"
        ).textContent = `${data.localidade}/${data.uf}`;

        enderecoAtual = {
          cep: data.cep,
          logradouro: data.logradouro,
          bairro: data.bairro,
          cidade: data.localidade,
          uf: data.uf,
        };
        resultadoBuscaDiv.style.display = "block";
      }
    } catch (error) {
      console.error("Erro ao buscar CEP:", error);
      alert("Ocorreu um erro de rede. Verifique sua conexão.");
    }
  }

  async function salvarEndereco() {
    if (!enderecoAtual.cep) {
      alert("Não há um endereço buscado para salvar.");
      return;
    }
    try {
      const response = await fetch("../src/salvar_endereco.php", {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(enderecoAtual),
      });

      if (response.ok) {
        alert("Endereço salvo com sucesso!");
        resultadoBuscaDiv.style.display = "none";
        enderecoAtual = {};
        carregarEnderecosSalvos();
      } else {
        const errorData = await response.json();
        alert("Erro ao salvar: " + (errorData.erro || "Erro desconhecido"));
      }
    } catch (error) {
      console.error("Erro ao salvar endereço:");
      alert("Ocorreu um erro de rede ao tentar salvar.");
    }
  }
  async function carregarEnderecosSalvos() {
    try {
      const response = await fetch("../src/buscar_enderecos.php", {
        credentials: "same-origin",
      });
      const enderecos = await response.json();
      enderecosSalvosDiv.innerHTML = "";
      if (enderecos.length === 0) {
        enderecosSalvosDiv.innerHTML =
          "<p>Você ainda não salvou nenhum endereço.</p>";
        return;
      }
      enderecos.forEach((end) => {
        const card = document.createElement("div");
        card.className = "card-endereco";
        card.innerHTML = `
        <h4>CEP: ${end.cep}</h4>
        <p>${end.logradouro || "<em>Logradouro não disponível</em>"}</p>
        <p><strong>Bairro:</strong> ${
          end.bairro || "<em>Não disponível</em>"
        }</p>
        <p><strong>Cidade:</strong> ${end.cidade} - ${end.uf}</p>
      `;
        enderecosSalvosDiv.appendChild(card);
      });
    } catch (error) {
      console.error("Erro ao carregar endereços:", error);
      enderecosSalvosDiv.innerHTML =
        "<p>Ocorreu um erro ao carregar seus endereços.</p>";
    }
  }
  buscarBtn.addEventListener("click", buscarCep);

  salvarBtn.addEventListener("click", salvarEndereco);

  carregarEnderecosSalvos();
});
