class EnhancedChatbot {
  constructor() {
    // DOM Elements
    this.chatBody = document.querySelector(".chat-body")
    this.messageInput = document.querySelector(".message-input")
    this.sendMessageButton = document.querySelector("#send-message")
    this.chatToggle = document.querySelector("#chatbot-toggle")
    this.chatPopup = document.querySelector("#chatbot-popup")
    this.minimizeBtn = document.querySelector("#minimize-chatbot")

    // Configuration
    this.API_KEY = "AIzaSyDvYh0lGdNrEEAEntitaBvmYejYQD8VCkI"
    this.API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${this.API_KEY}`

    // State
    this.isOpen = false
    this.isTyping = false
    this.conversationHistory = []
    this.userData = { message: null }

    // Initialize
    this.init()
  }

  init() {
    this.bindEvents()
    this.loadChatHistory()
    this.setupAutoResize()
    this.showWelcomeMessage()
  }

  bindEvents() {
    // Toggle chatbot
    if (this.chatToggle) {
      this.chatToggle.addEventListener("click", () => this.toggleChatbot())
    }

    if (this.minimizeBtn) {
      this.minimizeBtn.addEventListener("click", () => this.closeChatbot())
    }

    // Message handling
    this.messageInput.addEventListener("keydown", (e) => this.handleKeyDown(e))
    this.sendMessageButton.addEventListener("click", (e) => this.handleOutgoingMessage(e))

    // Auto-resize textarea
    this.messageInput.addEventListener("input", () => this.autoResizeTextarea())

    // Prevent form submission
    const chatForm = document.querySelector(".chat-form")
    if (chatForm) {
      chatForm.addEventListener("submit", (e) => e.preventDefault())
    }
  }

  toggleChatbot() {
    if (this.isOpen) {
      this.closeChatbot()
    } else {
      this.openChatbot()
    }
  }

  openChatbot() {
    if (this.chatPopup) {
      this.chatPopup.classList.add("show")
      this.chatToggle.classList.add("active")
      this.isOpen = true

      // Focus on input after animation
      setTimeout(() => {
        this.messageInput.focus()
      }, 300)
    }
  }

  closeChatbot() {
    if (this.chatPopup) {
      this.chatPopup.classList.remove("show")
      this.chatToggle.classList.remove("active")
      this.isOpen = false
    }
  }

  handleKeyDown(e) {
    const userMessage = e.target.value.trim()
    if (e.key === "Enter" && !e.shiftKey && userMessage && !this.isTyping) {
      e.preventDefault()
      this.handleOutgoingMessage(e)
    }
  }

  createMessageElement(content, ...classes) {
    const div = document.createElement("div")
    div.classList.add("message", ...classes)
    div.innerHTML = content
    return div
  }

  showWelcomeMessage() {
    // Only show if no previous messages
    if (this.chatBody.children.length <= 1) {
      setTimeout(() => {
        const welcomeMessages = [
          "Xin chào! 👋 Tôi là trợ lý ảo của cửa hàng.",
          "Tôi có thể giúp bạn tìm hiểu về sản phẩm, giá cả, chính sách đổi trả và nhiều thông tin khác.",
          "Bạn cần hỗ trợ gì hôm nay? 😊",
        ]

        welcomeMessages.forEach((msg, index) => {
          setTimeout(() => {
            this.addBotMessage(msg, false)
          }, index * 1000)
        })
      }, 500)
    }
  }

  addUserMessage(message) {
    const messageContent = `
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="message-text">${this.escapeHtml(message)}</div>
        `
    const outgoingMessageDiv = this.createMessageElement(messageContent, "user-message")
    this.chatBody.appendChild(outgoingMessageDiv)
    this.scrollToBottom()

    // Add to history
    this.conversationHistory.push({
      type: "user",
      message: message,
      timestamp: new Date().toISOString(),
    })
    this.saveChatHistory()
  }

  addBotMessage(message, isThinking = true) {
    if (isThinking) {
      // Show thinking indicator first
      const thinkingContent = `
                <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 1024 1024">
                    <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5z"/>
                </svg>
                <div class="message-text">
                    <div class="thinking-indicator">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            `
      const thinkingDiv = this.createMessageElement(thinkingContent, "bot-message", "thinking")
      this.chatBody.appendChild(thinkingDiv)
      this.scrollToBottom()
      return thinkingDiv
    } else {
      // Direct message without thinking
      const messageContent = `
                <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 1024 1024">
                    <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5z"/>
                </svg>
                <div class="message-text">${this.formatMessage(message)}</div>
            `
      const messageDiv = this.createMessageElement(messageContent, "bot-message")
      this.chatBody.appendChild(messageDiv)
      this.scrollToBottom()

      // Add to history
      this.conversationHistory.push({
        type: "bot",
        message: message,
        timestamp: new Date().toISOString(),
      })
      this.saveChatHistory()

      return messageDiv
    }
  }

  async generateBotResponse(incomingMessageDiv) {
    const messageElement = incomingMessageDiv.querySelector(".message-text")
    this.isTyping = true

    // Enhanced context with conversation history
    const contextHistory = this.conversationHistory
      .slice(-6) // Last 6 messages for context
      .map((item) => `${item.type}: ${item.message}`)
      .join("\n")

    const systemPrompt = `Bạn là một trợ lý tư vấn cho website bán giày và áo. Dưới đây là thông tin về website:
                            - Danh mục sản phẩm: 
                                + Giày: Giày sneaker,Giày thể thao,Giày boots,Giày chạy bộ,Giày local brand
                                + Áo: Áo thun,Áo sơ mi,Áo hoodie,Áo khoác,Áo tanktop
                            - sản phẩm chính:
                                + Giày sneaker: Nike Air Force 1 Low White,Adidas Ultraboost 22 Core Black,Converse Chuck Taylor All Star High,Vans Old Skool Black White,Puma Suede Classic Red,New Balance 574 Grey,MLB Big Ball Chunky A New York Yankees,Jordan 1 Mid Light Smoke Grey
                                + Giày boots: Timberland 6-Inch Premium Waterproof Boot,Dr. Martens 1460 Smooth Leather,Palladium Pampa Hi Organic,Caterpillar Colorado Boot,ed Wing Classic Moc Toe,Zara Chunky Leather Boot,H&M Chelsea Boot,Bershka Lace-Up Combat Boot
                                + Giày chạy bộ: Nike ZoomX Vaporfly NEXT%,Adidas Adizero Boston 11,New Balance Fresh Foam X 1080,Saucony Endorphin Speed 3,ASICS Novablast 3,Hoka One One Clifton 9,Mizuno Wave Rider Neo,Skechers GoRun Razor+
                                + Giày local Brand: Biti's Hunter Street,Ananas Urbas SC,Vintas Original Raw,Coolmate Xưởng Giày Everyday Sneaker,Gento Old School Classic,Swagger Chunky 2.0,RieNev Classic Street Black,Saigon Swagger Low Top

                                + Áo thun: Zara Oversized Basic Tee,H&M Regular Fit Printed T-shirt,Local Brand Tsimple Graphic Tee,Levents Essential Tee,Degrey Logo Basic Tee,DirtyCoins Monogram Tee
                                + Áo sơ mi: Owen Sơ mi công sở trắng trơn,An Phước Sơ mi họa tiết caro,Uniqlo Airism Shirt,H&M Slim Fit Cotton Shirt,Zara Striped Poplin Shirt,Routine Oxford Shirt,Coolmate Daily Shirt,Mango Slim Fit Printed Shirt
                                + Áo Hoodie: H&M Oversized Hoodie,DirtyCoins Signature Hoodie,Levents College Hoodie,Degrey Classic Hoodie,Local Brand SWE Hoodie,Zara Minimal Logo Hoodie,Routine Essential Hoodie
                                + Áo khoác: Adidas Windbreaker Jacket,Zara Bomber Jacket,Routine Varsity Jacket.H&M Padded Jacket,MLB Korea Jacket NY,Mango Tech Fabric Jacket
                                + Áo tanktop: Nike Pro Dri-Fit Tanktop,Adidas Performance Tanktop,Coolmate Performance Tanktop,H&M Sport Tanktop,Under Armour Training Tanktop,Gymshark Essential Tank,Local Brand TSIMPLE Classic Tank

                            - Chính sách đổi trả: Đổi hàng trong 7 ngày nếu sản phẩm còn nguyên tem, chưa qua sử dụng.
                                                 Miễn phí đổi size/màu 1 lần duy nhất.
                                                 Không áp dụng đổi/trả cho sản phẩm giảm giá quá 50%.
                                                 Khách hàng tự chịu phí vận chuyển nếu không phải do lỗi từ shop.
                            - Giao hàng: Toàn quốc, miễn phí với đơn trên 500.000đ,Thời gian giao: 2-5 ngày tùy khu vực,Có hỗ trợ kiểm tra hàng trước khi thanh toán (nếu dùng COD).
                            - Thanh toán: Chuyển khoản, COD

                            LỊCH SỬ HỘI THOẠI:
                            ${contextHistory}

                            HƯỚNG DẪN TRẢ LỜI:
                            - Trả lời bằng tiếng Việt, thân thiện và chuyên nghiệp
                            - Sử dụng emoji phù hợp
                            - Đưa ra gợi ý cụ thể về sản phẩm
                            - Nếu không biết thông tin, hãy thành thật và đề xuất liên hệ trực tiếp
                            - Khuyến khích khách hàng mua sắm một cách tự nhiên
                            - Tự động tra giá của các sản phẩm 

                            Câu hỏi của khách hàng: "${this.userData.message}"`

    const requestOptions = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        contents: [
          {
            parts: [{ text: systemPrompt }],
          },
        ],
        generationConfig: {
          temperature: 0.7,
          topK: 40,
          topP: 0.95,
          maxOutputTokens: 1024,
        },
      }),
    }

    try {
      const response = await fetch(this.API_URL, requestOptions)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.error?.message || "Có lỗi xảy ra khi kết nối API")
      }

      const apiResponseText = data.candidates[0].content.parts[0].text
        .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
        .trim()

      // Simulate typing effect
      await this.typeMessage(messageElement, apiResponseText)

      // Add to history
      this.conversationHistory.push({
        type: "bot",
        message: apiResponseText,
        timestamp: new Date().toISOString(),
      })
      this.saveChatHistory()
    } catch (error) {
      console.error("Chatbot Error:", error)
      const errorMessage = this.getErrorMessage(error)
      messageElement.innerHTML = `<span style="color: #ff4757;">${errorMessage}</span>`
    } finally {
      incomingMessageDiv.classList.remove("thinking")
      this.isTyping = false
      this.scrollToBottom()
    }
  }

  async typeMessage(element, text) {
    element.innerHTML = ""
    const words = text.split(" ")

    for (let i = 0; i < words.length; i++) {
      element.innerHTML += words[i] + " "
      this.scrollToBottom()
      await new Promise((resolve) => setTimeout(resolve, 50)) // Typing speed
    }
  }

  getErrorMessage(error) {
    if (error.message.includes("API key")) {
      return "🔑 Lỗi xác thực API. Vui lòng liên hệ quản trị viên."
    } else if (error.message.includes("quota")) {
      return "⚠️ Đã vượt quá giới hạn sử dụng. Vui lòng thử lại sau."
    } else if (error.message.includes("network") || error.message.includes("fetch")) {
      return "🌐 Lỗi kết nối mạng. Vui lòng kiểm tra internet và thử lại."
    } else {
      return "❌ Xin lỗi, tôi gặp sự cố kỹ thuật. Vui lòng thử lại sau ít phút."
    }
  }

  handleOutgoingMessage(e) {
    e.preventDefault()

    if (this.isTyping) {
      this.showNotification("Vui lòng đợi bot trả lời...", "warning")
      return
    }

    this.userData.message = this.messageInput.value.trim()

    if (!this.userData.message) {
      this.messageInput.focus()
      return
    }

    // Add user message
    this.addUserMessage(this.userData.message)
    this.messageInput.value = ""
    this.autoResizeTextarea()

    // Generate bot response with delay
    setTimeout(() => {
      const thinkingDiv = this.addBotMessage("", true)
      this.generateBotResponse(thinkingDiv)
    }, 600)
  }

  formatMessage(message) {
    return message
      .replace(/\n/g, "<br>")
      .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
      .replace(/\*(.*?)\*/g, "<em>$1</em>")
  }

  escapeHtml(text) {
    const div = document.createElement("div")
    div.textContent = text
    return div.innerHTML
  }

  scrollToBottom() {
    setTimeout(() => {
      this.chatBody.scrollTo({
        top: this.chatBody.scrollHeight,
        behavior: "smooth",
      })
    }, 100)
  }

  autoResizeTextarea() {
    this.messageInput.style.height = "auto"
    this.messageInput.style.height = Math.min(this.messageInput.scrollHeight, 100) + "px"
  }

  setupAutoResize() {
    this.messageInput.style.height = "auto"
    this.messageInput.style.overflowY = "hidden"
  }

  saveChatHistory() {
    try {
      localStorage.setItem("chatbot_history", JSON.stringify(this.conversationHistory))
    } catch (error) {
      console.warn("Could not save chat history:", error)
    }
  }

  loadChatHistory() {
    try {
      const saved = localStorage.getItem("chatbot_history")
      if (saved) {
        this.conversationHistory = JSON.parse(saved)
        // Optionally restore recent messages to UI
        // this.restoreRecentMessages();
      }
    } catch (error) {
      console.warn("Could not load chat history:", error)
      this.conversationHistory = []
    }
  }

  clearChatHistory() {
    this.conversationHistory = []
    localStorage.removeItem("chatbot_history")

    // Clear chat UI except welcome message
    const messages = this.chatBody.querySelectorAll(".message")
    messages.forEach((msg, index) => {
      if (index > 0) {
        // Keep first welcome message
        msg.remove()
      }
    })

    this.showNotification("Đã xóa lịch sử chat", "success")
  }

  showNotification(message, type = "info") {
    // Create notification element
    const notification = document.createElement("div")
    notification.className = `chat-notification ${type}`
    notification.textContent = message

    // Style notification
    Object.assign(notification.style, {
      position: "fixed",
      top: "20px",
      right: "20px",
      padding: "12px 20px",
      borderRadius: "8px",
      color: "white",
      fontWeight: "500",
      zIndex: "10000",
      transform: "translateX(100%)",
      transition: "transform 0.3s ease",
    })

    // Set background color based on type
    const colors = {
      success: "#28a745",
      warning: "#ffc107",
      error: "#dc3545",
      info: "#17a2b8",
    }
    notification.style.backgroundColor = colors[type] || colors.info

    document.body.appendChild(notification)

    // Animate in
    setTimeout(() => {
      notification.style.transform = "translateX(0)"
    }, 100)

    // Remove after delay
    setTimeout(() => {
      notification.style.transform = "translateX(100%)"
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification)
        }
      }, 300)
    }, 3000)
  }

  // Public methods for external control
  sendMessage(message) {
    this.messageInput.value = message
    this.handleOutgoingMessage(new Event("click"))
  }

  getConversationHistory() {
    return this.conversationHistory
  }

  setApiKey(newApiKey) {
    this.API_KEY = newApiKey
    this.API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${this.API_KEY}`
  }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  window.chatbot = new EnhancedChatbot()

  // Add global methods for external access
  window.sendChatMessage = (message) => window.chatbot.sendMessage(message)
  window.clearChatHistory = () => window.chatbot.clearChatHistory()
  window.getChatHistory = () => window.chatbot.getConversationHistory()
})

// Add some CSS for better styling
const additionalStyles = `
<style>
.thinking-indicator {
    display: flex;
    gap: 4px;
    padding: 15px 0;
    align-items: center;
}

.thinking-indicator .dot {
    width: 8px;
    height: 8px;
    background: #667eea;
    border-radius: 50%;
    animation: thinking 1.4s infinite ease-in-out;
}

.thinking-indicator .dot:nth-child(1) { animation-delay: 0s; }
.thinking-indicator .dot:nth-child(2) { animation-delay: 0.2s; }
.thinking-indicator .dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes thinking {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.4;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

.user-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    flex-shrink: 0;
}

.message-text strong {
    color: #667eea;
    font-weight: 600;
}

.message-text em {
    color: #6c757d;
    font-style: italic;
}

.chat-notification {
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
`

// Inject additional styles
document.head.insertAdjacentHTML("beforeend", additionalStyles)
