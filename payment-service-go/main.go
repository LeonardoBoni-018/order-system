package main

import (
	"net/http"
	"time"

	"github.com/gin-gonic/gin"
)

type PaymentRequest struct {
	OrderID int     `json:"order_id"`
	Amount  float64 `json:"amount"`
}

type PaymentResponse struct {
	Status  string `json:"status"`
	Message string `json:"message"`
}

func main() {
	r := gin.Default()

	r.POST("/pay", func(c *gin.Context) {
		var req PaymentRequest

		if err := c.ShouldBindJSON(&req); err != nil {
			c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
			return
		}

		// simulação de processamento
		time.Sleep(1 * time.Second)

		c.JSON(http.StatusOK, PaymentResponse{
			Status:  "approved",
			Message: "Pagamento aprovado",
		})
	})

	r.Run(":8081")
}
