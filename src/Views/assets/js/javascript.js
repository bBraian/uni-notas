$('#nova_cadeira').on('click', () => {
    var cadeira = $('#nome_cadeira_modal').val();
    var cor = $('#cor_modal').val();
    if(cadeira != "" && cor != "") {

    var formData = new FormData();

    formData.append('cadeira', cadeira);
    formData.append('cor', cor);
    formData.append('tipo', 'novo');

    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST',
        url: '../Controllers/Ajax/NotasAjax.php',
        success: function (response) {
            console.log(response);
            var json = JSON.parse(response);
            if(json.erro === 'N') {
                location.reload();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: json.mensagem,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        },
        error: function () {
            var json = JSON.parse(response);
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Erro de comunicacao:' + json,
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Preencha todos os campos',
            showConfirmButton: false,
            timer: 1500
        })
    }
})

$('#select-cadeiras').on('change', () => {
    var selected_chair = $('#select-cadeiras').val();
    
    var formData = new FormData();
    formData.append('cadeira_selecionada', selected_chair);
    formData.append('tipo', 'validate_chair');

    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST',
        url: '../Controllers/Ajax/NotasAjax.php',
        beforeSend: function () {
            $.LoadingOverlay("show");
            $('#form-add-notas').hide();
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            console.log(response);
            var json = JSON.parse(response);
            if(json.erro === 'N') {
                $('#form-add-notas').show();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Cadeira inválida!'
                })
            }
        },
        error: function () {
            var json = JSON.parse(response);
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Erro de comunicacao:' + json+' Recarregue a página, por favor',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
})

$('#nova_nota').on('click', () => {
    var grau = $('#select_grau').val();
    var descricao = $('#descricao_nota').val();
    var nota = $('#nota_grau').val();
    var nota_max = $('#nota_max_grau').val();
    var cadeira = $('#select-cadeiras').val();

    var formData = new FormData();
    formData.append('grau', grau);
    formData.append('descricao', descricao);
    formData.append('nota', nota);
    formData.append('nota_max', nota_max);
    formData.append('cadeira', cadeira);
    formData.append('tipo', 'salvar_nota');

    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST',
        url: '../Controllers/Ajax/NotasAjax.php',
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            console.log(response);
            var json = JSON.parse(response);
            if(json.erro === 'N') {
                Swal.fire({
                    icon: 'success',
                    title: 'Uhuul',
                    text: 'Nota inserida com sucesso!'
                }).then(() => {
                    location.reload();
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Cadeira inválida!'
                })
            }
        },
        error: function () {
            var json = JSON.parse(response);
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Erro de comunicacao:' + json+' Recarregue a página, por favor',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
})

$('#btn-voltar').on('click', () => {
    window.location.href = 'http://localhost/uni-notas/src/Views/index.php';
})

function openCadeira(id) {
    window.location.href = 'http://localhost/uni-notas/src/Views/cadeira.php?id='+id;
}