<style>
      /* 1. Botón flotante para abrir el chat */
      #amazon-connect-open-widget-button {
        background: #FFFFFF url("https://www.veris.com.ec/wp-content/uploads/2026/10/logo-vericita.png") center / contain no-repeat !important;
        border: 0 !important;
        box-shadow: 0 4px 16px rgba(10, 34, 64, 0.2) !important;
        border-radius: 50% !important;
      }
      
      #amazon-connect-open-widget-button > * { 
        visibility: hidden !important; 
      }

      /* 2. Contenedor del Iframe: limita la altura responsiva */
      #amazon-connect-chat-iframe-container {
        max-height: 85vh !important;
        bottom: 20px !important;
        right: 20px !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(10, 34, 64, 0.25) !important;
      }

      /* 3. BORDES REDONDEADOS PARA LOS BOTONES DEL FOOTER */
      /* Forzamos el border-radius en los botones dentro del iframe/widget de Amazon Connect */
      [class*="Footer"] button,
      [class*="footer"] button,
      #amazon-connect-chat-iframe-container button {
        border-radius: 20px !important; /* Bordes redondeados/cápsula */
        padding: 8px 16px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
      }
    </style>

    <script type="text/javascript">
      (function(w, d, x, id){
        s=d.createElement('script');
        s.src='https://veris-dev.my.connect.aws/connectwidget/static/amazon-connect-chat-interface-client.js';
        s.async=1;
        s.id=id;
        d.getElementsByTagName('head')[0].appendChild(s);
        w[x] =  w[x] || function() { (w[x].ac = w[x].ac || []).push(arguments) };
      })(window, document, 'amazon_connect', '3fa526e0-9d9f-4666-b06d-06bac6a535b0');

      amazon_connect('styles', { 
        iconType: 'CHAT_VOICE', 
        openChat: { color: '#ffffff', backgroundColor: '#296BEF' }, 
        closeChat: { color: '#ffffff', backgroundColor: '#296BEF' } 
      });
      
      amazon_connect('snippetId', 'QVFJREFIaThPZ042Z2Vwd1EzbWNOOW9zZVBpdlltbFlYREFwbEVldGoySmJEcktXREFHY0hOMCtQM1pUNXpTZ3dSditrTTlWQUFBQWJqQnNCZ2txaGtpRzl3MEJCd2FnWHpCZEFnRUFNRmdHQ1NxR1NJYjNEUUVIQVRBZUJnbGdoa2dCWlFNRUFTNHdFUVFNVWlDTGhrMjFUZkZGckhrdUFnRVFnQ3YweUFPcWlFVkNIWmViZ2hxR1RJNEZOZ2xva3dacmNHWVpVYzJaK2lVbUJKV3VxSklZRCtQb3hGNlY6OjcrZDdVTUx0b0VhbzdDaHFVNXhLTWQxd0dWZktkMXFGQ3doNjRSMWZKOENoWlRkV2xWYkE2UGwvTFJMUTRaelpueEozN0NaTlREQysxVGlxZ0RkS3V5QTcrUGIySFFEL2ZsQlM2VURKOEg1QzgxeGIrRi9KczVpWDdXKzUwQzdKTW1LYW5pekpHeWdQNmp1a01KWjE3b0JPQldLdDRhaz0=');
      amazon_connect('supportedMessagingContentTypes', [ 'text/plain', 'text/markdown', 'application/vnd.amazonaws.connect.message.interactive', 'application/vnd.amazonaws.connect.message.interactive.response' ]);
      amazon_connect('language', 'es_ES');
      amazon_connect('mockLexBotTyping', true);

      amazon_connect('customStyles', {
        global:      { textColor: '#0A2240', fontSize: '15px', frameWidth: '390px', frameHeight: '80vh' },
        header:      { headerTextColor: '#FFFFFF', headerBackgroundColor: '#296BEF' },
        transcript:  { widgetBackgroundColor: '#FFFFFF',
                       agentChatBubbleColor: '#F3F4F5', systemChatBubbleColor: '#F3F4F5',
                       customerChatBubbleColor: '#296BEF',
                       agentMessageTextColor: '#0A2240', systemMessageTextColor: '#0A2240',
                       customerMessageTextColor: '#FFFFFF' },
        footer:      { footerBackgroundColor: '#F9FAFB', buttonTextColor: '#296BEF',
                       buttonBorderColor: '#D0D5DD', buttonBackgroundColor: '#FFFFFF' },
        composer:    { textColor: '#0A2240', backgroundColor: '#FFFFFF', borderColor: '#D0D5DD',
                       focusBorderColor: '#296BEF', placeholderColor: '#6B7280' },
        logo:        { logoMaxHeight: '28px', logoMaxWidth: '80%' },
        fullscreenMode: true
      });

      amazon_connect('customizationObject', {
        transcript: {
          displayIcons: true,
          iconSources: { botMessage: 'https://www.veris.com.ec/wp-content/uploads/2025/05/vericita.png', systemMessage: 'https://www.veris.com.ec/wp-content/uploads/2025/05/vericita.png' },
          eventNames: { customer: 'Usuario' },
          eventMessages: { participantJoined: '{name} se unió al chat', chatEnded: 'El chat finalizó' }
        },
        endChat: { enableConfirmationDialog: true,
                   confirmationDialogText: { title: 'Finalizar chat', message: '¿Quieres terminar esta conversación?',
                                             confirmButtonText: 'Finalizar', cancelButtonText: 'Cancelar' } }
      });

      amazon_connect('customDisplayNames', {
        header: { logoUrl: 'https://www.veris.com.ec/wp-content/uploads/2026/10/logo-vericita.png', logoAltText: 'VeriCita' },
        transcript: { systemMessageDisplayName: 'VeriCita', botMessageDisplayName: 'VeriCita' }
      });

      amazon_connect('updateSandboxAttributes',
        'allow-scripts allow-same-origin allow-popups allow-downloads allow-modals allow-popups-to-escape-sandbox');
    </script>