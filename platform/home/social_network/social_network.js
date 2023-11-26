document.addEventListener('DOMContentLoaded', function() {
    // Call selectContact() with the first contact's name
    selectContact('John');
  });
  
  function selectContact(contactName) {
    const chatMessages = document.getElementById('chat-messages');
    
    // Clear previous messages
    chatMessages.innerHTML = '';
    
    // Add new messages based on selected contact
    if (contactName === 'John') {
      const message1 = createMessage('John', 'Hello, how are you?');
      const message2 = createMessage('You', 'I\'m good, thanks! How about you?');
      chatMessages.appendChild(message1);
      chatMessages.appendChild(message2);
    } else if (contactName === 'Jane') {
      const message1 = createMessage('Jane', 'Hey, what\'s up?');
      const message2 = createMessage('You', 'Not much, just chilling.');
      chatMessages.appendChild(message1);
      chatMessages.appendChild(message2);
    }
    // Add more conditions for other contacts
    
    // Scroll to the bottom of the chat
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
  
  function createMessage(sender, content) {
    const message = document.createElement('div');
    message.classList.add('message');
    
    const senderElement = document.createElement('div');
    senderElement.classList.add('sender');
    senderElement.textContent = sender;
    
    const contentElement = document.createElement('div');
    contentElement.classList.add('content');
    contentElement.textContent = content;
    
    message.appendChild(senderElement);
    message.appendChild(contentElement);
    
    return message;
  }
  