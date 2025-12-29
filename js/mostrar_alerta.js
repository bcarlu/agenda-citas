// Asegura que el contenedor para la alerta existe
function ensureContainer() {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
  }
  return container;
}

// Genera el HTML para la alerta
function makeToastHtml(message, type) {
    if (type === 'exito') {
        return '<div class="alert alert-success mb-0" role="alert">' + message + '</div>';
    }
    if (type === 'error') {
        return '<div class="alert alert-danger mb-0" role="alert">' + message + '</div>';
    }
    if (type === 'aviso') {
        return '<div class="alert alert-warning mb-0" role="alert">' + message + '</div>';
    }    
}

// Muestra la alerta
function showToast(message, type, timeout = 3000) {
  const container = ensureContainer();
  const node = document.createElement('div');
  node.className = 'toast';
  node.innerHTML = makeToastHtml(message, type);
  container.appendChild(node);

  // force reflow to allow transition
    void node.offsetWidth;
    node.classList.add('show');

    // remove after timeout
    setTimeout(() => {
        node.classList.remove('show');
        setTimeout(() => {
            try { container.removeChild(node); } catch(e){}
        }, 200);
    }, timeout);
}

// Se configura la funcion showToast para que se pueda usar globalmente, sin necesidad de usar import
window.showToast = showToast;