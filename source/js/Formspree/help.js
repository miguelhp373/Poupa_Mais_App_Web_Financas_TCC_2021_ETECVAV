var form = document.getElementById("contactForm");
    
async function handleSubmit(event) {
  event.preventDefault();
  //var status = document.getElementById("my-form-status");
  var data = new FormData(event.target);
  fetch(event.target.action, {
    method: form.method,
    body: data,
    headers: {
        'Accept': 'application/json'
    }
  }).then(response => {
    alert('Mensagem Enviada Com Sucesso!');
    form.reset();
    window.location.href = '../../index.php';
  }).catch(error => {
    alert('Erro Ao Tentar Enviar Mensagem!');
  });
}
form.addEventListener("submit", handleSubmit)
