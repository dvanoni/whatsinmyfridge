# Echo server program
import socket
import threading

HOST = ''    # Symbolic name meaning all available interfaces
PORT = 8788


print "Starting server..."


listenSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listenSocket.bind( (HOST, PORT) )
listenSocket.listen(5)

clientSocket = None


def handleMessage ( data ):
	msgArray = data.split(',')


class ListenThread ( threading.Thread ):

	def run ( self ):

		global listenSocket
		global clientSocket

		while True:
			print "Waiting for client..."
			try:
				clientSocket, details = listenSocket.accept()
				if not clientSocket:
					break
			except:
				break
			else:
				print "Client connected."

				while True:
					print "Waiting to receive..."
					try:
						data = clientSocket.recv(1024)
						if not data:
							break
					except:
						break
					else:
						print data
						handleMessage(data)

				print "Client disconnected."

		print "Listening stopped."



listener = ListenThread()
listener.start()


print "Type 'q' to quit"

input = ''
while (input != 'q'):
	input = raw_input()

print "Shutting down..."

listenSocket.shutdown(socket.SHUT_RDWR)
listenSocket.close()

if clientSocket:
	clientSocket.shutdown(socket.SHUT_RDWR)
	clientSocket.close()


while listener.isAlive():
	listener.join()

print "Done."

