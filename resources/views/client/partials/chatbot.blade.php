
  
    <!-- Chatbot Toggle Button -->
    <div class="chatbot-toggle" id="chatbot-toggle">
        <svg class="chatbot-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
            <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5z"/>
        </svg>
        <span class="close-icon material-symbols-rounded">close</span>
    </div>

    <!-- Chatbot Popup -->
    <div class="chatbot-popup" id="chatbot-popup">
        <!-- Chatbot Header -->
        <div class="chat-header">
            <div class="header-info">
                <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                    <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5z"/>
                </svg>
                <div class="header-text">
                    <h3 class="logo-text">Chatbot</h3>
                    <span class="status-text">Đang hoạt động</span>
                </div>
            </div>
            <button id="minimize-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
        </div>

        <!-- Chatbot Body -->
        <div class="chat-body" id="chat-body">
            <div class="message bot-message">
                <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 1024 1024">
                    <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5z"/>
                </svg>
                <div class="message-text">
                    Xin chào! 👋<br>
                    Tôi là chatbot hỗ trợ. Tôi có thể giúp bạn trả lời các câu hỏi và hỗ trợ bạn.
                </div>
            </div>
        </div>

        <!-- Chatbot Footer -->
        <div class="chat-footer">
            <form class="chat-form" id="chat-form">
                <textarea placeholder="Nhập tin nhắn..." class="message-input" id="message-input" rows="1"></textarea>
                <div class="chat-controls">
                    <button class="material-symbols-rounded emoji-btn" type="button" title="Emoji">sentiment_satisfied</button>
                    <button class="material-symbols-rounded attach-btn" type="button" title="Đính kèm">attach_file</button>
                    <button class="material-symbols-rounded send-btn" id="send-message" type="submit" title="Gửi">send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification Badge -->
