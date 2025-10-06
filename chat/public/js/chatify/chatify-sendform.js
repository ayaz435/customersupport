
document.addEventListener('DOMContentLoaded', function () {
    const endChatButton = document.querySelector('.endchat');
    const transferchatButton = document.querySelector('.transferchat');
    const messageForm = document.getElementById('message-form');
    const messageInput = messageForm.querySelector('textarea[name="message"]');
    const sendButton = messageForm.querySelector('.send-button');

    endChatButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the form from being submitted immediately
        messageInput.value = "Do you want to end chat"; // Set the message
        sendButton.click(); // Simulate a click on the submit button
    });
    transferchatButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the form from being submitted immediately
        showTransferModal();
    });

});

// Create a modal for selecting the agent to transfer to
function showTransferModal() {
    // Get current conversation info
    const customerId = getMessengerId();
    // Create modal HTML
    const modalHTML = `
            <div class="transfer-modal-backdrop">
                <div class="transfer-modal">
                    <div class="transfer-modal-header">
                        <h4>Transfer Chat</h4>
                        <span class="close-transfer-modal" onclick="closeTransferModal()">&times;</span>
                    </div>
                    <div class="transfer-modal-body">
                        <p class="mb-1">Select agent type:</p>
                
                        <div class="member-type-toggle">
                            <label>
                                <input type="radio" name="memberType" value="support" checked> Support Members
                            </label>
                            <label style="margin-left: 15px;">
                                <input type="radio" name="memberType" value="service"> Service Members
                            </label>
                        </div>

                        <div class="member-dropdown mt-3">
                            <label for="target-agent-select">Select an agent to transfer this conversation to:</label>
                            <select id="target-agent-select" class="form-control mt-1">
                                <option value="">Loading agents...</option>
                            </select>
                        </div>

                        <div class="transfer-note mt-3">
                            <p>Optional note for the receiving agent:</p>
                            <textarea id="transfer-note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="transfer-modal-footer">
                        <button class="btn cancel" onclick="closeTransferModal()">Cancel</button>
                        <button class="btn transfer" onclick="transferChat()">Transfer</button>
                    </div>
                </div>
            </div>
        `;

    // Append modal to body
    $('body').append(modalHTML);

    // Load available agents (you'll need an endpoint for this)
    // loadAvailableAgents();
    loadAvailableAgents("support");

    $('input[name="memberType"]').on('change', function () {
        const type = $(this).val();
        loadAvailableAgents(type);
    });
}

function loadAvailableAgents(type = "support") {

    $.ajax({
        url: url + "/fetchAgents",
        method: "POST",
        data: {
            _token: csrfToken,
        },
        dataType: "JSON",
        xhrFields: {
            withCredentials: true
        },
        dataType: "JSON",
        success: function (data) {
            const selectElement = $('#target-agent-select');
            selectElement.empty();

            let list = [];
            if (type === "support") {
                list = data.agents || [];
            } else if (type === "service") {
                list = data.service_agents || [];
            }

            if (list.length > 0) {
                list.forEach(agent => {
                    if (agent.id != auth_id) {
                        selectElement.append(
                            `<option value="${agent.id}">${agent.name}</option>`
                        );
                    }
                });
                // if (data.agents && data.agents.length > 0) {
                //     data.agents.forEach(agent => {
                //         // Don't include the current agent in the list
                //         if (agent.id != auth_id) {
                //             selectElement.append(`<option value="${agent.id}">${agent.name}</option>`);
                //         }
                //     });
            } else {
                selectElement.append('<option value="">No agents available</option>');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            $('#target-agent-select').html('<option value="">Failed to load agents</option>');
        }
    });
}

// Close the transfer modal
function closeTransferModal() {
    $('.transfer-modal-backdrop').remove();
}

// Execute the chat transfer
function transferChat() {
    const targetAgentId = $('#target-agent-select').val();
    const transferNote = $('#transfer-note').val();
    const customerId = getMessengerId();
    // const currentConversationId = $('.messenger-list-item .m-list-active').attr('data-contact');

    // console.log(currentConversationId);

    if (!targetAgentId) {
        alert('Please select an agent to transfer to.');
        return;
    }

    // Show loading state
    $('.transfer-modal-footer .transfer').text('Transferring...').prop('disabled', true);

    // Call the transfer API
    $.ajax({
        url: url + "/transfer-chat",
        type: 'POST',
        dataType: 'json',
        data: {
            current_conversation_id: customerId,
            customer_id: customerId,
            target_agent_id: targetAgentId,
            transfer_note: transferNote,
            _token: csrfToken // Make sure you have the CSRF token available
        },
        success: function (data) {
            $('.transfer-modal-backdrop').remove();
            // if (data.status) {
            // Display success message
            showSuccessMessage('Chat successfully transferred to ' + data.message);

            $('.messenger-list-item[data-contact="' + customerId + '"] .lastMessageIndicator')
                .after('<span class="transferred-label">Transferred</span>');

            // } else {
            //     alert('Failed to transfer chat: ' + data.message);
            //     $('.transfer-modal-footer .transfer').text('Transfer').prop('disabled', false);
            // }
        },
        error: function (xhr) {
            let errorMessage = 'An error occurred during transfer.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            alert('Failed to transfer chat: ' + errorMessage);
            $('.transfer-modal-footer .transfer').text('Transfer').prop('disabled', false);
        }
    });
}

// Helper function to show success message
function showSuccessMessage(message) {
    const successAlert = `
            <div class="alert alert-success transfer-alert">
            ${message}
                    <span class="close-alert" onclick="$(this).parent().fadeOut()">&times;</span>
                </div>
            `;

    $('body').append(successAlert);

    // Auto dismiss after 5 seconds
    setTimeout(function () {
        $('.transfer-alert').fadeOut();
    }, 5000);
}

/*
        // This function loads the complete chat history when receiving a transferred chat
        function loadTransferredChatHistory(customerId) {
            // alert("sending ajax");
            $.ajax({
                url: url + "/chat-history/${customerId}",
                type: 'POST',
                dataType: 'json',
                data: {
                    customer_id:customerId,
                    _token: csrfToken 
                },
                success: function(data) {
                    if (data.status && data.messages) {
                        // Clear current messages
                        $('.messages').empty();

                        // Add a transfer notice at the top if the chat has been transferred
                        if (data.has_been_transferred) {
                            let transferNotice = `
                                <div class="message-card system-message transfer-notice">
                                    <p class="m-0">
                                        <i class="fas fa-exchange-alt"></i>
                                        This chat has been transferred to you.
                                        ${data.transfer_count > 1 ? `It has been transferred ${data.transfer_count} times.` : ''}
                                        Full conversation history is displayed below.
                                    </p>
                                </div>
                            `;
                            $('.messages').append(transferNotice);
                        }

                        // Append all messages to the chat window
                        data.messages.forEach(message => {
                            let messageClass = message.is_sender ? 'sent' : 'received';
                            let senderInfo = '';

                            // Add sender info for received messages
                            if (!message.is_sender && message.type !== 'system') {
                                senderInfo = `<div class="sender-info">${message.sender_name}</div>`;
                            }

                            // Create the message element
                            let messageElement = '';

                            if (message.type === 'system') {
                                // System message styling with special handling for transfer messages
                                let systemClass = message.transferred ? 'system-message transfer-message' : 'system-message';

                                messageElement = `
                                    <div class="message-card ${systemClass}">
                                        <p class="m-0">${message.message}</p>
                                        <div class="message-time">${message.time}</div>
                                    </div>
                                `;
                            } else {
                                // Regular message styling
                                let attachmentMarkup = '';
                                if (message.attachment) {
                                    // Handle attachment display based on type
                                    let fileExtension = message.attachment.split('.').pop().toLowerCase();

                                    // Images
                                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                                        attachmentMarkup = `
                                    <div class="attachment image-attachment">
                                        <img src="${message.attachment}" class="chat-image" />
                                    </div>`;
                                    }
                                    // Files
                                    else {
                                        attachmentMarkup = `
                                    <div class="attachment file-attachment">
                                        <a href="${message.attachment}" target="_blank" class="file-download-link">
                                            <span class="file-icon"><i class="fas fa-file"></i></span>
                                            <span class="file-name">${message.attachment.split('/').pop()}</span>
                                        </a>
                                    </div>`;
                                    }
                                }

                                messageElement = `
                            <div class="message-card ${messageClass} ${message.transferred ? 'transferred-message' : ''}">
                                ${senderInfo}
                                <div class="message-content">
                                    <p class="m-0">${message.message}</p>
                                    ${attachmentMarkup}
                                </div>
                                <div class="message-time">${message.time}</div>
                            </div>
                        `;
                            }

                            $('.messages').append(messageElement);
                        });

                        // Scroll to bottom
                        scrollToBottom();

                        // Update the conversation info to show it's a transferred chat
                        if (data.has_been_transferred) {
                            updateConversationInfo(customerId, data.transfer_count);
                        }
                    }
                },
                error: function() {
                    // Display error message
                    $('.messages').append(`
                <div class="message-card system-message error">
                    <p class="m-0">Failed to load complete chat history. Please refresh and try again.</p>
                </div>
            `);
                }
            });
        }*/

// Function to update the conversation info with transfer details
function updateConversationInfo(customerId, transferCount) {
    // Get customer name
    const customerName = $(`.messenger-list-item[data-contact="${customerId}"]`).find('.messenger-title').text();

    // Add transfer badge to the conversation info
    setTimeout(function () {
        if ($('.transfer-badge').length === 0) {
            $('.messenger-title-container').append(`
            <span class="transfer-badge" title="This chat has been transferred ${transferCount} times">
                <i class="fas fa-exchange-alt"></i> Transferred
            </span>
        `);
        }
    }, 500);
}

// Initialize our custom functionality
$(document).ready(function () {

    // Check if this is a transferred chat when opening a conversation
    $(document).on('click', '.messenger-list-item', function () {
        const customerId = $(this).attr('data-contact');
        // alert(customerId);
        loadTransferredChatHistory(customerId);

    });

    // Add custom styles for our new elements
    const customStyles = `
                <style>
                    .transfer-chat {
                        background: #3490dc;
                        color: white;
                        border: none;
                        padding: 8px 12px;
                        border-radius: 4px;
                        cursor: pointer;
                        margin-top: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                    }
        
                    .transfer-chat span {
                        margin-right: 5px;
                    }
        
                    .transfer-modal-backdrop {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0,0,0,0.5);
                        z-index: 1050;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
        
                    .transfer-modal {
                        background: white;
                        border-radius: 8px;
                        width: 500px;
                        max-width: 90%;
                        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                        overflow: hidden;
                    }
        
                    .transfer-modal-header {
                        padding: 15px;
                        border-bottom: 1px solid #e9ecef;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
        
                    .transfer-modal-body {
                        padding: 15px;
                    }
        
                    .transfer-modal-footer {
                        padding: 15px;
                        border-top: 1px solid #e9ecef;
                        display: flex;
                        justify-content: flex-end;
                        gap: 10px;
                    }
        
                    .close-transfer-modal {
                        font-size: 24px;
                        cursor: pointer;
                    }
        
                    .transfer-note {
                        margin-top: 15px;
                    }
        
                    .transferred-label {
                        background: #3490dc;
                        color: white;
                        font-size: 10px;
                        padding: 2px 5px;
                        border-radius: 3px;
                        margin-left: 5px;
                    }
        
                    .system-message {
                        background-color: #f3f3f3;
                        color: #555;
                        padding: 8px 12px;
                        border-radius: 6px;
                        text-align: center;
                        margin: 10px 0;
                        font-style: italic;
                    }
        
                    .system-message.error {
                        background-color: #fee2e2;
                        color: #ef4444;
                    }
        
                    .sender-info {
                        font-size: 12px;
                        color: #666;
                        margin-bottom: 3px;
                    }
        
                    .alert.transfer-alert {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 15px;
                        z-index: 1060;
                        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    }
        
                    .close-alert {
                        margin-left: 10px;
                        cursor: pointer;
                    }
                </style>
            `;

    $('head').append(customStyles);
});