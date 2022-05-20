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

function excluirCadeira(id) {
    Swal.fire({
        title: 'Atenção',
        text: "Deseja excluir o registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append('tipo', 'delete');
            formData.append('id', id);

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
                            text: 'Cadeira deletada com sucesso!'
                        }).then(() => {
                            window.location.href = "http://localhost/uni-notas/src/Views/index.php";
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
        }
    })
}

function excluirNota(id) {
    Swal.fire({
        title: 'Atenção',
        text: "Deseja excluir a nota?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append('tipo', 'delete_nota');
            formData.append('id', id);

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
                            text: 'Nota deletada com sucesso!'
                        }).then(() => {
                            document.location.reload(true);
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
        }
    })
}

function editarNota(id) {
    var descricao = $('#descricao-'+id).text();
    var nota = $('#nota-'+id).text();
    var nota_max = $('#nota-max-'+id).text();

    $('#edit-icon-'+id).hide();
    $('#delete-icon-'+id).hide();
    $('#save-icon-'+id).show();
    $('#cancel-icon-'+id).show();

    $('#descricao-'+id).html(`<input type='text' class="input-descricao-edit" id="descricao-edit-`+id+`" value="`+descricao+`"></input>`);
    $('#nota-'+id).html(`<input type='number' class="input-nota-edit" id="nota-edit-`+id+`" value="`+nota+`"></input>`);
    $('#nota-max-'+id).html(`<input type='number' class="input-nota-edit" id="nota-max-edit-`+id+`" value="`+nota_max+`"></input>`);
}

function cancelUpdateNota(id) {
    $('#descricao-'+id).html($('#desc-backup-'+id).val());
    $('#nota-'+id).html($('#nota-backup-'+id).val());
    $('#nota-max-'+id).html($('#nota-max-backup-'+id).val());

    $('#edit-icon-'+id).show();
    $('#delete-icon-'+id).show();
    $('#save-icon-'+id).hide();
    $('#cancel-icon-'+id).hide();
}

function updateNota(id) {
    var descricao = $('#descricao-edit-'+id).val();
    var nota = $('#nota-edit-'+id).val();
    var nota_max = $('#nota-max-edit-'+id).val();

    var formData = new FormData();
    formData.append('descricao', descricao);
    formData.append('nota', nota);
    formData.append('nota_max', nota_max);
    formData.append('id', id);
    formData.append('tipo', 'update_nota');

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
                    title: 'Sucesso',
                    text: 'Nota atualizada!'
                }).then(() => {
                    location.reload();
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao atualizar nota!'
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
}