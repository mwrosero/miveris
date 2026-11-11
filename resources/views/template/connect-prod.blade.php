<script type="text/javascript">
  (function(w, d, x, id){
    s=d.createElement('script');
    s.src='https://veris-connect-prod.my.connect.aws/connectwidget/static/amazon-connect-chat-interface-client.js';
    s.async=1;
    s.id=id;
    d.getElementsByTagName('head')[0].appendChild(s);
    w[x] =  w[x] || function() { (w[x].ac = w[x].ac || []).push(arguments) };
  })(window, document, 'amazon_connect', '5822061c-724c-4ccf-a9b7-442591a8b17d');

  amazon_connect('styles', { 
    iconType: 'CHAT_VOICE', 
    openChat: { color: '#ffffff', backgroundColor: '#296BEF' }, 
    closeChat: { color: '#ffffff', backgroundColor: '#296BEF' } 
  });
  
  amazon_connect('snippetId', 'QVFJREFIaVBWbXNtcVFNOWdRdG1RUXNJdXY1Vk81RFMveGMyT0owMWQ1NlVUbXpsYkFHdzYyTS84NzFhYmxObnBpRVEvUUsvQUFBQWJqQnNCZ2txaGtpRzl3MEJCd2FnWHpCZEFnRUFNRmdHQ1NxR1NJYjNEUUVIQVRBZUJnbGdoa2dCWlFNRUFTNHdFUVFNL3VmUDN6bFpSUzRPcW5iVUFnRVFnQ3VWRDFlSGMzTHdWRG1GYzQzQWFkWUpqSXpzanYyYnM1bUQxZVFFNGRpU2p2MUF4TmRXcTdHRm9ZY0I6OnZlTE51aEoxS00wMnI1Q0d1QjcraHJaQWl1bnB2Y0ZJUGszeTVFMHlScytVNzRSYWYxak1aMUsza2kxQ2pNcXhXWTRCLzhES1FzVTluT2EvRU5nclMxbVhhTDdEYUFFQStkcGhnYmNUYld6Wm1UaXpJZEFRbXdNMG8yQVNTdkp0WVhhYmtoSXBIb25XMkhxWDljK2gzS3FNVDJBQ0pjQT0=');
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
    transcript: { systemMessageDisplayName: 'VeriCita', botMessageDisplayName: 'VeriCita' },
	footer: {
    	textInputPlaceholder: 'Escriba un mensaje...',
    	endChatButtonText: 'Finalizar chat',
    	startCallButtonText: 'Iniciar una llamada'
  	}
  });

  amazon_connect('updateSandboxAttributes',
    'allow-scripts allow-same-origin allow-popups allow-downloads allow-modals allow-popups-to-escape-sandbox');
</script>