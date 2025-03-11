// document.body.addEventListener('click', function (event) {
//     console.log("goooood");

//     if (event.target.classList.contains('deleteButton')) {
//         const button = event.target;
//         const taskId = button.getAttribute('data-id'); // Récupère l'ID
//         console.log("ID de la tâche à supprimer :", taskId);

//         const container = button.closest('.itemContainer');
//         if (!container) return;

//         const modal = container.querySelector('.deleteModal');
//         if (modal) {
//             modal.classList.remove('hidden');
//             document.body.classList.add('body-modal-open');
//         }
//     }

//     if (event.target.classList.contains('cancelButton')) {
//         const button = event.target;
//         const modal = button.closest('.deleteModal');
//         if (modal) {
//             modal.classList.add('hidden');
//             document.body.classList.remove('body-modal-open');
//         }
//     }

//     if (event.target.classList.contains('confirmButton')) {
//         const button = event.target;
//         const taskId = button.getAttribute('data-id'); // Récupère l'ID
//         console.log("Confirme la suppression de la tâche :", taskId);

//         const modal = button.closest('.deleteModal');
//         if (!modal) return;

//         const container = modal.closest('.itemContainer');
//         if (!container) return;

//         const form = container.querySelector('.deleteForm');
//         if (modal) {
//             modal.classList.add('hidden');
//             document.body.classList.remove('body-modal-open');
//         }
//         if (form) {
//             // Ajoutez l'ID de la tâche à un champ caché si nécessaire
//             const hiddenInput = form.querySelector('input[name="taskId"]');
//             if (hiddenInput) {
//                 hiddenInput.value = taskId; // Assurez-vous que l'ID est dans le formulaire
//             }

//             form.submit();
//         }
//     }
// });
